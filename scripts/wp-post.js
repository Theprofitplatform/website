/**
 * WordPress REST API Helper for The Profit Platform
 * 
 * This utility helps manage WordPress content via the REST API
 * Useful for hybrid content management and automation
 */

const https = require('https');
const http = require('http');

class WordPressAPI {
  constructor(siteUrl, username, applicationPassword) {
    this.siteUrl = siteUrl.replace(/\/$/, ''); // Remove trailing slash
    this.username = username;
    this.applicationPassword = applicationPassword;
    this.apiBase = `${this.siteUrl}/wp-json/wp/v2`;
  }

  /**
   * Make authenticated request to WordPress REST API
   */
  async makeRequest(endpoint, method = 'GET', data = null) {
    const url = new URL(`${this.apiBase}${endpoint}`);
    const options = {
      hostname: url.hostname,
      port: url.port || (url.protocol === 'https:' ? 443 : 80),
      path: url.pathname + url.search,
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Basic ${Buffer.from(`${this.username}:${this.applicationPassword}`).toString('base64')}`
      }
    };

    if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
      const jsonData = JSON.stringify(data);
      options.headers['Content-Length'] = Buffer.byteLength(jsonData);
    }

    return new Promise((resolve, reject) => {
      const request = (url.protocol === 'https:' ? https : http).request(options, (response) => {
        let body = '';
        
        response.on('data', (chunk) => {
          body += chunk;
        });

        response.on('end', () => {
          try {
            const jsonResponse = JSON.parse(body);
            if (response.statusCode >= 200 && response.statusCode < 300) {
              resolve(jsonResponse);
            } else {
              reject(new Error(`HTTP ${response.statusCode}: ${jsonResponse.message || body}`));
            }
          } catch (error) {
            reject(new Error(`Failed to parse JSON response: ${error.message}`));
          }
        });
      });

      request.on('error', (error) => {
        reject(error);
      });

      if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
        request.write(JSON.stringify(data));
      }

      request.end();
    });
  }

  /**
   * Create a new post
   */
  async createPost(postData) {
    return this.makeRequest('/posts', 'POST', postData);
  }

  /**
   * Update an existing post
   */
  async updatePost(postId, postData) {
    return this.makeRequest(`/posts/${postId}`, 'POST', postData);
  }

  /**
   * Get posts
   */
  async getPosts(params = {}) {
    const queryString = new URLSearchParams(params).toString();
    const endpoint = queryString ? `/posts?${queryString}` : '/posts';
    return this.makeRequest(endpoint);
  }

  /**
   * Create a new page
   */
  async createPage(pageData) {
    return this.makeRequest('/pages', 'POST', pageData);
  }

  /**
   * Update an existing page
   */
  async updatePage(pageId, pageData) {
    return this.makeRequest(`/pages/${pageId}`, 'POST', pageData);
  }

  /**
   * Get pages
   */
  async getPages(params = {}) {
    const queryString = new URLSearchParams(params).toString();
    const endpoint = queryString ? `/pages?${queryString}` : '/pages';
    return this.makeRequest(endpoint);
  }

  /**
   * Upload media file
   */
  async uploadMedia(filePath, filename, mimeType) {
    // Note: This is a simplified version. For production use,
    // you'd want to handle file uploads with proper multipart/form-data
    console.log(`Media upload functionality would be implemented here for: ${filename}`);
    return { message: 'Media upload not implemented in this simple version' };
  }

  /**
   * Get site health information
   */
  async getSiteHealth() {
    try {
      const posts = await this.makeRequest('/posts?per_page=1');
      const pages = await this.makeRequest('/pages?per_page=1');
      
      return {
        status: 'healthy',
        api_accessible: true,
        posts_count: posts.length,
        pages_count: pages.length,
        timestamp: new Date().toISOString()
      };
    } catch (error) {
      return {
        status: 'error',
        api_accessible: false,
        error: error.message,
        timestamp: new Date().toISOString()
      };
    }
  }
}

// Example usage and CLI functionality
if (require.main === module) {
  const args = process.argv.slice(2);
  
  if (args.length < 1) {
    console.log(`
Usage: node wp-post.js <command> [options]

Commands:
  health-check <site-url> <username> <app-password>
  create-post <site-url> <username> <app-password> <title> <content>
  create-page <site-url> <username> <app-password> <title> <content>

Example:
  node wp-post.js health-check https://theprofitplatform.com.au admin your-app-password
  node wp-post.js create-post https://theprofitplatform.com.au admin pass "New Post" "Post content here"
    `);
    process.exit(1);
  }

  const command = args[0];
  
  async function runCommand() {
    try {
      switch (command) {
        case 'health-check':
          if (args.length < 4) {
            throw new Error('health-check requires: <site-url> <username> <app-password>');
          }
          
          const wp = new WordPressAPI(args[1], args[2], args[3]);
          const health = await wp.getSiteHealth();
          console.log(JSON.stringify(health, null, 2));
          break;

        case 'create-post':
          if (args.length < 6) {
            throw new Error('create-post requires: <site-url> <username> <app-password> <title> <content>');
          }
          
          const wpPost = new WordPressAPI(args[1], args[2], args[3]);
          const postResult = await wpPost.createPost({
            title: args[4],
            content: args[5],
            status: 'draft' // Create as draft by default
          });
          console.log('Post created:', postResult);
          break;

        case 'create-page':
          if (args.length < 6) {
            throw new Error('create-page requires: <site-url> <username> <app-password> <title> <content>');
          }
          
          const wpPage = new WordPressAPI(args[1], args[2], args[3]);
          const pageResult = await wpPage.createPage({
            title: args[4],
            content: args[5],
            status: 'draft' // Create as draft by default
          });
          console.log('Page created:', pageResult);
          break;

        default:
          throw new Error(`Unknown command: ${command}`);
      }
    } catch (error) {
      console.error('Error:', error.message);
      process.exit(1);
    }
  }

  runCommand();
}

module.exports = WordPressAPI;