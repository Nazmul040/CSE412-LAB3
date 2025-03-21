-- Create the database
CREATE DATABASE IF NOT EXISTS resume_builder;
USE resume_builder;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Templates table
CREATE TABLE IF NOT EXISTS templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Resumes table
CREATE TABLE IF NOT EXISTS resumes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    template VARCHAR(50) NOT NULL,
    template_id INT NOT NULL,
    completion_percentage INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (template_id) REFERENCES templates(id)
);

-- Resume data table (stores JSON data for each section)
CREATE TABLE IF NOT EXISTS resume_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resume_id INT NOT NULL,
    section VARCHAR(50) NOT NULL,
    data JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resume_id) REFERENCES resumes(id) ON DELETE CASCADE,
    UNIQUE KEY (resume_id, section)
);

-- Insert default templates
INSERT INTO templates (name, description, thumbnail) VALUES
('Professional', 'A clean and professional template suitable for most industries.', 'professional.jpg'),
('Modern', 'A modern and creative template with a unique layout.', 'modern.jpg'),
('Minimal', 'A minimalist template that focuses on content with clean typography.', 'minimal.jpg'),
('Executive', 'An elegant template designed for senior positions and executives.', 'executive.jpg'),
('Creative', 'A colorful and creative template perfect for design and creative roles.', 'creative.jpg');

-- Create index for performance
CREATE INDEX idx_resume_user ON resumes(user_id);
CREATE INDEX idx_resume_data_resume ON resume_data(resume_id);