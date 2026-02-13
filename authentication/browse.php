<?php
session_start();
$is_logged_in = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Thesis - Thesis Archiving System</title>
    <link rel="stylesheet" href="css/browse.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="homepage.php" class="logo">
                <div class="logo-icon">📚</div>
                <span>Thesis Archive</span>
            </a>
            <ul class="nav-links">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="browse.php" class="active">Browse Thesis</a></li>
                <li><a href="about.php">About</a></li>
                <?php if ($is_logged_in): ?>
                    <li><a href="student-dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="browse-header">
            <h1>Browse Archived Thesis</h1>
            <p>Explore our collection of approved and archived academic thesis</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-section">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Search by title, keywords, or abstract...">
                <button class="search-btn">🔍 Search</button>
            </div>
            
            <div class="filter-bar">
                <select class="filter-select">
                    <option value="">All Categories</option>
                    <option value="cs">Computer Science</option>
                    <option value="it">Information Technology</option>
                    <option value="engineering">Engineering</option>
                    <option value="business">Business</option>
                    <option value="education">Education</option>
                    <option value="health">Health Sciences</option>
                    <option value="social">Social Sciences</option>
                </select>
                
                <select class="filter-select">
                    <option value="">All Years</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>
                
                <button class="clear-btn">Clear Filters</button>
            </div>
        </div>

        <!-- Results Info -->
        <div class="results-info">
            <p>Found <strong>12 thesis</strong></p>
        </div>

        <!-- Thesis Cards Grid -->
        <div class="thesis-grid">
            <!-- Thesis Card 1 -->
            <div class="thesis-card">
                <div class="thesis-header">
                    <h3 class="thesis-title">AI-Based Recommendation System for E-Commerce Applications</h3>
                    <span class="category-badge">Computer Science</span>
                </div>
                
                <div class="thesis-meta">
                    <span class="author">👤 Juan Dela Cruz</span>
                    <span class="date">📅 January 2025</span>
                </div>
                
                <p class="thesis-abstract">
                    This research proposes an artificial intelligence-based recommendation system designed to enhance user experience in e-commerce platforms. Using collaborative filtering and deep learning techniques, the system analyzes user behavior patterns...
                </p>
                
                <div class="thesis-keywords">
                    <strong>Keywords:</strong>
                    <span class="keyword">AI</span>
                    <span class="keyword">Machine Learning</span>
                    <span class="keyword">E-commerce</span>
                    <span class="keyword">Recommendation System</span>
                </div>
                
                <div class="thesis-actions">
                    <button class="btn-view">View Details</button>
                    <button class="btn-download">📥 Download PDF</button>
                </div>
            </div>

            <!-- Thesis Card 2 -->
            <div class="thesis-card">
                <div class="thesis-header">
                    <h3 class="thesis-title">Mobile Health Application for Diabetes Management</h3>
                    <span class="category-badge category-health">Health Sciences</span>
                </div>
                
                <div class="thesis-meta">
                    <span class="author">👤 Maria Santos</span>
                    <span class="date">📅 December 2024</span>
                </div>
                
                <p class="thesis-abstract">
                    A comprehensive mobile health application developed to assist diabetes patients in monitoring their blood glucose levels, tracking medication schedules, and managing dietary intake through an intuitive interface...
                </p>
                
                <div class="thesis-keywords">
                    <strong>Keywords:</strong>
                    <span class="keyword">Mobile App</span>
                    <span class="keyword">Healthcare</span>
                    <span class="keyword">Diabetes</span>
                    <span class="keyword">Patient Monitoring</span>
                </div>
                
                <div class="thesis-actions">
                    <button class="btn-view">View Details</button>
                    <button class="btn-download">📥 Download PDF</button>
                </div>
            </div>

            <!-- Thesis Card 3 -->
            <div class="thesis-card">
                <div class="thesis-header">
                    <h3 class="thesis-title">Blockchain Technology for Secure Academic Credential Verification</h3>
                    <span class="category-badge category-it">Information Technology</span>
                </div>
                
                <div class="thesis-meta">
                    <span class="author">👤 Pedro Reyes</span>
                    <span class="date">📅 November 2024</span>
                </div>
                
                <p class="thesis-abstract">
                    This study presents a blockchain-based system for verifying and storing academic credentials, eliminating fraud and streamlining the verification process for educational institutions and employers...
                </p>
                
                <div class="thesis-keywords">
                    <strong>Keywords:</strong>
                    <span class="keyword">Blockchain</span>
                    <span class="keyword">Security</span>
                    <span class="keyword">Credentials</span>
                    <span class="keyword">Verification</span>
                </div>
                
                <div class="thesis-actions">
                    <button class="btn-view">View Details</button>
                    <button class="btn-download">📥 Download PDF</button>
                </div>
            </div>

            <!-- Thesis Card 4 -->
            <div class="thesis-card">
                <div class="thesis-header">
                    <h3 class="thesis-title">Smart Irrigation System Using IoT Technology</h3>
                    <span class="category-badge category-eng">Engineering</span>
                </div>
                
                <div class="thesis-meta">
                    <span class="author">👤 Carlos Mendoza</span>
                    <span class="date">📅 October 2024</span>
                </div>
                
                <p class="thesis-abstract">
                    An innovative IoT-based irrigation system that optimizes water usage in agricultural settings through real-time soil moisture monitoring and automated water distribution...
                </p>
                
                <div class="thesis-keywords">
                    <strong>Keywords:</strong>
                    <span class="keyword">IoT</span>
                    <span class="keyword">Agriculture</span>
                    <span class="keyword">Smart Systems</span>
                    <span class="keyword">Automation</span>
                </div>
                
                <div class="thesis-actions">
                    <button class="btn-view">View Details</button>
                    <button class="btn-download">📥 Download PDF</button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <button class="page-btn" disabled>← Previous</button>
            <button class="page-btn page-active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">Next →</button>
        </div>
    </div>
</body>
</html>