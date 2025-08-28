/**
 * Health Check Script for The Profit Platform Website
 * 
 * This script performs comprehensive health checks on the website
 * including performance, SEO, and functionality tests
 */

import https from 'https';
import http from 'http';
import { URL } from 'url';

class HealthChecker {
  constructor(siteUrl) {
    this.siteUrl = siteUrl;
    this.results = {
      timestamp: new Date().toISOString(),
      site: siteUrl,
      overall_status: 'unknown',
      checks: {}
    };
  }

  /**
   * Make HTTP request and return response data
   */
  async makeRequest(url, timeout = 10000) {
    return new Promise((resolve, reject) => {
      const urlObj = new URL(url);
      const options = {
        hostname: urlObj.hostname,
        port: urlObj.port || (urlObj.protocol === 'https:' ? 443 : 80),
        path: urlObj.pathname + urlObj.search,
        method: 'GET',
        timeout: timeout,
        headers: {
          'User-Agent': 'The-Profit-Platform-Health-Check/1.0'
        }
      };

      const request = (urlObj.protocol === 'https:' ? https : http).request(options, (response) => {
        let body = '';
        
        response.on('data', (chunk) => {
          body += chunk;
        });

        response.on('end', () => {
          resolve({
            statusCode: response.statusCode,
            headers: response.headers,
            body: body,
            responseTime: Date.now() - startTime
          });
        });
      });

      const startTime = Date.now();

      request.on('error', (error) => {
        reject(error);
      });

      request.on('timeout', () => {
        request.destroy();
        reject(new Error('Request timeout'));
      });

      request.end();
    });
  }

  /**
   * Check if site is accessible
   */
  async checkAccessibility() {
    try {
      const response = await this.makeRequest(this.siteUrl);
      
      this.results.checks.accessibility = {
        status: response.statusCode === 200 ? 'pass' : 'fail',
        statusCode: response.statusCode,
        responseTime: response.responseTime,
        message: response.statusCode === 200 ? 'Site is accessible' : `HTTP ${response.statusCode}`
      };
    } catch (error) {
      this.results.checks.accessibility = {
        status: 'fail',
        error: error.message,
        message: 'Site is not accessible'
      };
    }
  }

  /**
   * Check response time performance
   */
  async checkPerformance() {
    try {
      const response = await this.makeRequest(this.siteUrl);
      const responseTime = response.responseTime;
      
      let status = 'fail';
      let message = 'Slow response time';
      
      if (responseTime < 1000) {
        status = 'excellent';
        message = 'Excellent response time';
      } else if (responseTime < 3000) {
        status = 'good';
        message = 'Good response time';
      } else if (responseTime < 5000) {
        status = 'fair';
        message = 'Fair response time';
      }

      this.results.checks.performance = {
        status: status,
        responseTime: responseTime,
        message: message,
        benchmark: 'Target: <3000ms'
      };
    } catch (error) {
      this.results.checks.performance = {
        status: 'fail',
        error: error.message,
        message: 'Unable to measure performance'
      };
    }
  }

  /**
   * Check SSL certificate
   */
  async checkSSL() {
    if (!this.siteUrl.startsWith('https://')) {
      this.results.checks.ssl = {
        status: 'fail',
        message: 'Site is not using HTTPS'
      };
      return;
    }

    try {
      const response = await this.makeRequest(this.siteUrl);
      
      this.results.checks.ssl = {
        status: 'pass',
        message: 'SSL certificate is working',
        https: true
      };
    } catch (error) {
      this.results.checks.ssl = {
        status: 'fail',
        error: error.message,
        message: 'SSL certificate issue detected'
      };
    }
  }

  /**
   * Check for basic SEO elements
   */
  async checkSEO() {
    try {
      const response = await this.makeRequest(this.siteUrl);
      const html = response.body;
      
      const checks = {
        hasTitle: /<title[^>]*>([^<]+)<\/title>/i.test(html),
        hasMetaDescription: /<meta[^>]*name=["']description["'][^>]*content=["']([^"']+)["']/i.test(html),
        hasH1: /<h1[^>]*>([^<]+)<\/h1>/i.test(html),
        hasStructuredData: /application\/ld\+json/i.test(html) || /schema\.org/i.test(html)
      };

      const passedChecks = Object.values(checks).filter(Boolean).length;
      const totalChecks = Object.keys(checks).length;
      
      this.results.checks.seo = {
        status: passedChecks === totalChecks ? 'pass' : passedChecks > totalChecks / 2 ? 'partial' : 'fail',
        score: `${passedChecks}/${totalChecks}`,
        details: checks,
        message: `SEO elements: ${passedChecks}/${totalChecks} found`
      };
    } catch (error) {
      this.results.checks.seo = {
        status: 'fail',
        error: error.message,
        message: 'Unable to check SEO elements'
      };
    }
  }

  /**
   * Check WordPress specific endpoints
   */
  async checkWordPress() {
    try {
      // Check if wp-json endpoint is accessible
      const wpApiResponse = await this.makeRequest(`${this.siteUrl}/wp-json/wp/v2`);
      
      let wpVersion = 'unknown';
      let wpStatus = 'unknown';
      
      if (wpApiResponse.statusCode === 200) {
        wpStatus = 'accessible';
        
        // Try to get WordPress version from generator meta tag
        const homeResponse = await this.makeRequest(this.siteUrl);
        const versionMatch = homeResponse.body.match(/<meta name="generator" content="WordPress ([^"]+)"/i);
        if (versionMatch) {
          wpVersion = versionMatch[1];
        }
      }

      this.results.checks.wordpress = {
        status: wpStatus === 'accessible' ? 'pass' : 'fail',
        version: wpVersion,
        apiAccessible: wpStatus === 'accessible',
        message: wpStatus === 'accessible' ? 'WordPress REST API is accessible' : 'WordPress REST API not accessible'
      };
    } catch (error) {
      this.results.checks.wordpress = {
        status: 'fail',
        error: error.message,
        message: 'Unable to check WordPress status'
      };
    }
  }

  /**
   * Check for mobile responsiveness indicators
   */
  async checkMobile() {
    try {
      const response = await this.makeRequest(this.siteUrl);
      const html = response.body;
      
      const hasViewportMeta = /<meta[^>]*name=["']viewport["']/i.test(html);
      const hasResponsiveCSS = /responsive|mobile|@media/i.test(html);
      
      this.results.checks.mobile = {
        status: hasViewportMeta ? 'pass' : 'fail',
        hasViewport: hasViewportMeta,
        hasResponsiveIndicators: hasResponsiveCSS,
        message: hasViewportMeta ? 'Mobile viewport meta tag found' : 'Mobile viewport meta tag missing'
      };
    } catch (error) {
      this.results.checks.mobile = {
        status: 'fail',
        error: error.message,
        message: 'Unable to check mobile responsiveness'
      };
    }
  }

  /**
   * Check for security headers
   */
  async checkSecurity() {
    try {
      const response = await this.makeRequest(this.siteUrl);
      const headers = response.headers;
      
      const securityChecks = {
        hasXFrameOptions: headers['x-frame-options'] !== undefined,
        hasXContentTypeOptions: headers['x-content-type-options'] !== undefined,
        hasXXSSProtection: headers['x-xss-protection'] !== undefined,
        hasStrictTransportSecurity: headers['strict-transport-security'] !== undefined
      };

      const passedChecks = Object.values(securityChecks).filter(Boolean).length;
      const totalChecks = Object.keys(securityChecks).length;
      
      this.results.checks.security = {
        status: passedChecks > totalChecks / 2 ? 'pass' : 'partial',
        score: `${passedChecks}/${totalChecks}`,
        details: securityChecks,
        message: `Security headers: ${passedChecks}/${totalChecks} found`
      };
    } catch (error) {
      this.results.checks.security = {
        status: 'fail',
        error: error.message,
        message: 'Unable to check security headers'
      };
    }
  }

  /**
   * Run all health checks
   */
  async runAllChecks() {
    console.log(`🏥 Starting health check for ${this.siteUrl}...`);
    
    await this.checkAccessibility();
    await this.checkPerformance();
    await this.checkSSL();
    await this.checkSEO();
    await this.checkWordPress();
    await this.checkMobile();
    await this.checkSecurity();

    // Determine overall status
    const checkStatuses = Object.values(this.results.checks).map(check => check.status);
    const failCount = checkStatuses.filter(status => status === 'fail').length;
    const passCount = checkStatuses.filter(status => status === 'pass' || status === 'excellent' || status === 'good').length;
    
    if (failCount === 0) {
      this.results.overall_status = 'healthy';
    } else if (failCount <= checkStatuses.length / 2) {
      this.results.overall_status = 'partial';
    } else {
      this.results.overall_status = 'unhealthy';
    }

    return this.results;
  }

  /**
   * Generate a formatted report
   */
  generateReport() {
    console.log('\n📊 HEALTH CHECK REPORT');
    console.log('========================');
    console.log(`Site: ${this.results.site}`);
    console.log(`Overall Status: ${this.results.overall_status.toUpperCase()}`);
    console.log(`Timestamp: ${this.results.timestamp}\n`);

    for (const [checkName, result] of Object.entries(this.results.checks)) {
      const statusIcon = {
        'pass': '✅',
        'excellent': '🚀',
        'good': '✅',
        'fair': '⚠️',
        'partial': '⚠️',
        'fail': '❌'
      }[result.status] || '❓';

      console.log(`${statusIcon} ${checkName.toUpperCase()}: ${result.status}`);
      console.log(`   ${result.message}`);
      
      if (result.responseTime) {
        console.log(`   Response time: ${result.responseTime}ms`);
      }
      
      if (result.score) {
        console.log(`   Score: ${result.score}`);
      }
      
      if (result.error) {
        console.log(`   Error: ${result.error}`);
      }
      
      console.log('');
    }
  }
}

// CLI usage
if (import.meta.url === `file://${process.argv[1]}`) {
  const siteUrl = process.argv[2] || 'https://theprofitplatform.com.au';
  
  console.log(`🚀 The Profit Platform Health Check`);
  console.log(`====================================`);
  
  const checker = new HealthChecker(siteUrl);
  
  try {
    await checker.runAllChecks();
    checker.generateReport();
    
    // Exit with error code if site is unhealthy
    process.exit(checker.results.overall_status === 'unhealthy' ? 1 : 0);
  } catch (error) {
    console.error('Health check failed:', error.message);
    process.exit(1);
  }
}

export default HealthChecker;