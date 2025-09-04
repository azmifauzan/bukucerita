require('dotenv').config()
const express = require('express')
const cors = require('cors')
const helmet = require('helmet')
const { createClient } = require('@supabase/supabase-js')

const app = express()
app.use(helmet())
app.use(cors())
app.use(express.json())

const SUPABASE_URL = process.env.SUPABASE_URL
const SUPABASE_SERVICE_KEY = process.env.SUPABASE_SERVICE_KEY

if (!SUPABASE_URL || !SUPABASE_SERVICE_KEY) {
  console.error('Missing SUPABASE_URL or SUPABASE_SERVICE_KEY in environment')
  process.exit(1)
}

const supabase = createClient(SUPABASE_URL, SUPABASE_SERVICE_KEY)

// Simple health
app.get('/health', (req, res) => res.json({ ok: true, time: Date.now() }))

// Get approved books (with optional limit)
app.get('/books', async (req, res) => {
  try {
    const limit = parseInt(req.query.limit) || 100
    const { data, error } = await supabase
      .from('books')
      .select('*')
      .eq('status', 'approved')
      .order('read_count', { ascending: false })
      .limit(limit)

    if (error) return res.status(500).json({ error: error.message || error })
    res.json(data)
  } catch (err) {
    res.status(500).json({ error: err.message })
  }
})

// Get single book
app.get('/books/:id', async (req, res) => {
  try {
    const id = req.params.id
    const { data, error } = await supabase
      .from('books')
      .select('*')
      .eq('id', id)
      .single()
    if (error) return res.status(404).json({ error: error.message || error })
    res.json(data)
  } catch (err) {
    res.status(500).json({ error: err.message })
  }
})

// Create book (public submissions) -> status pending
app.post('/books', async (req, res) => {
  try {
    const payload = req.body
    const insert = {
      title: payload.title,
      author: payload.author,
      synopsis: payload.synopsis || null,
      cover_image: payload.cover_image || payload.coverImage || null,
      gemini_storybook_url: payload.gemini_storybook_url || payload.geminiStorybookUrl || null,
      status: 'pending',
      read_count: 0
    }
    const { data, error } = await supabase
      .from('books')
      .insert([insert])
      .select()
    if (error) return res.status(500).json({ error: error.message || error })
    res.status(201).json(data[0])
  } catch (err) {
    res.status(500).json({ error: err.message })
  }
})

// Increment read_count (RPC preferred)
app.post('/books/:id/increment', async (req, res) => {
  try {
    const id = req.params.id
    // Try RPC if exists
    try {
      const { error } = await supabase.rpc('increment_read_count', { book_id: id })
      if (error) throw error
      return res.json({ ok: true })
    } catch (rpcErr) {
      // Fallback to incrementing via update
      const { data, error } = await supabase
        .from('books')
        .select('read_count')
        .eq('id', id)
        .single()
      if (error) return res.status(500).json({ error: error.message || error })
      const newCount = (data.read_count || 0) + 1
      const { data: updated, error: updErr } = await supabase
        .from('books')
        .update({ read_count: newCount })
        .eq('id', id)
        .select()
      if (updErr) return res.status(500).json({ error: updErr.message || updErr })
      return res.json({ ok: true, read_count: newCount })
    }
  } catch (err) {
    res.status(500).json({ error: err.message })
  }
})

// Admin endpoints (requires service key) - update or delete
app.put('/admin/books/:id', async (req, res) => {
  try {
    const id = req.params.id
    const updates = req.body
    const { data, error } = await supabase
      .from('books')
      .update(updates)
      .eq('id', id)
      .select()
    if (error) return res.status(500).json({ error: error.message || error })
    res.json(data[0])
  } catch (err) {
    res.status(500).json({ error: err.message })
  }
})

app.delete('/admin/books/:id', async (req, res) => {
  try {
    const id = req.params.id
    const { error } = await supabase
      .from('books')
      .delete()
      .eq('id', id)
    if (error) return res.status(500).json({ error: error.message || error })
    res.json({ ok: true })
  } catch (err) {
    res.status(500).json({ error: err.message })
  }
})

const PORT = process.env.PORT || 4000
app.listen(PORT, () => console.log(`Server listening on ${PORT}`))
