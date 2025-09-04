import { createClient } from '@supabase/supabase-js'

// Get environment variables with fallback
const supabaseUrl = process.env.VUE_APP_SUPABASE_URL
const supabaseAnonKey = process.env.VUE_APP_SUPABASE_ANON_KEY

// Only create client if we have valid credentials
let supabase = null
let isSupabaseEnabled = false

if (supabaseUrl && supabaseAnonKey && 
    supabaseUrl !== 'YOUR_SUPABASE_URL' && 
    supabaseAnonKey !== 'YOUR_SUPABASE_ANON_KEY' &&
    supabaseUrl.startsWith('http')) {
  try {
    supabase = createClient(supabaseUrl, supabaseAnonKey)
    isSupabaseEnabled = true
    console.log('✅ Supabase client initialized successfully')
  } catch (error) {
    console.warn('⚠️ Failed to initialize Supabase client:', error)
    isSupabaseEnabled = false
  }
} else {
  console.log('ℹ️ Supabase credentials not found or invalid, using local data fallback')
}

export { supabase, isSupabaseEnabled }

// Book service functions
export const bookService = {
  // Get all approved books
  async getApprovedBooks() {
    if (!isSupabaseEnabled) {
      console.log('📚 Using local data fallback for approved books')
      const { default: books } = await import('@/data/books.json')
      return books.filter(book => book.status === 'approved')
    }

    try {
      const { data, error } = await supabase
        .from('books')
        .select('*')
        .eq('status', 'approved')
        .order('read_count', { ascending: false })
      
      if (error) throw error
      return data || []
    } catch (error) {
      console.error('❌ Error fetching approved books from Supabase:', error)
      // Fallback to local data if Supabase fails
      console.log('📚 Falling back to local data')
      const { default: books } = await import('@/data/books.json')
      return books.filter(book => book.status === 'approved')
    }
  },

  // Get all books (for admin/collection page)
  async getAllBooks() {
    if (!isSupabaseEnabled) {
      console.log('📚 Using local data fallback for all books')
      const { default: books } = await import('@/data/books.json')
      return books
    }

    try {
      const { data, error } = await supabase
        .from('books')
        .select('*')
        .order('created_at', { ascending: false })
      
      if (error) throw error
      return data || []
    } catch (error) {
      console.error('❌ Error fetching all books from Supabase:', error)
      // Fallback to local data if Supabase fails
      console.log('📚 Falling back to local data')
      const { default: books } = await import('@/data/books.json')
      return books
    }
  },

  // Get single book by ID
  async getBookById(id) {
    if (!isSupabaseEnabled) {
      console.log('📚 Using local data fallback for book by ID')
      const { default: books } = await import('@/data/books.json')
      return books.find(book => book.id == id)
    }

    try {
      const { data, error } = await supabase
        .from('books')
        .select('*')
        .eq('id', id)
        .single()
      
      if (error) throw error
      return data
    } catch (error) {
      console.error('❌ Error fetching book from Supabase:', error)
      // Fallback to local data if Supabase fails
      console.log('📚 Falling back to local data')
      const { default: books } = await import('@/data/books.json')
      return books.find(book => book.id == id)
    }
  },

  // Add new book
  async addBook(bookData) {
    if (!isSupabaseEnabled) {
      console.log('📚 Supabase not available, simulating book addition')
      // Simulate successful addition
      return {
        id: Date.now(),
        ...bookData,
        status: 'pending',
        read_count: 0,
        created_at: new Date().toISOString()
      }
    }

    try {
      const { data, error } = await supabase
        .from('books')
        .insert([{
          ...bookData,
          status: 'pending',
          read_count: 0,
          created_at: new Date().toISOString()
        }])
        .select()
      
      if (error) throw error
      return data[0]
    } catch (error) {
      console.error('❌ Error adding book to Supabase:', error)
      throw error
    }
  },

  // Update book
  async updateBook(id, updates) {
    if (!isSupabaseEnabled) {
      console.log('📚 Supabase not available, simulating book update')
      return { id, ...updates }
    }

    try {
      const { data, error } = await supabase
        .from('books')
        .update(updates)
        .eq('id', id)
        .select()
      
      if (error) throw error
      return data[0]
    } catch (error) {
      console.error('❌ Error updating book in Supabase:', error)
      throw error
    }
  },

  // Delete book
  async deleteBook(id) {
    if (!isSupabaseEnabled) {
      console.log('📚 Supabase not available, simulating book deletion')
      return true
    }

    try {
      const { error } = await supabase
        .from('books')
        .delete()
        .eq('id', id)
      
      if (error) throw error
      return true
    } catch (error) {
      console.error('❌ Error deleting book from Supabase:', error)
      throw error
    }
  },

  // Increment read count
  async incrementReadCount(id) {
    if (!isSupabaseEnabled) {
      console.log('📚 Supabase not available, skipping read count increment')
      return
    }

    try {
      const { error } = await supabase.rpc('increment_read_count', { book_id: id })
      if (error) throw error
    } catch (error) {
      console.error('❌ Error incrementing read count in Supabase:', error)
    }
  }
}
