# Grit: An AI-Powered Career Assistant

Grit is a modern web application built to help job seekers take full control of their career search. It acts as a smart application tracker that goes beyond simple lists. Grit uses artificial intelligence to analyze your resume, compare it to specific job postings, and help you prepare for real interviews.

## What It Does

Finding a job requires organization and strategy. Grit solves this by combining a project management board with AI tools. Users can save jobs they want to apply for, upload their customized resumes, and ask the system to calculate how well they match the role. If a user gets an interview, Grit will generate custom practice questions based on the exact job description and the user's uploaded resume.

## Core Features

* **Interactive Job Board:** Manage your applications with a smooth interface. You can track roles from the "Matched" stage all the way to "Hired" or "Rejected" with ease.
* **Smart Resume Storage:** Upload and organize your PDF resumes securely. You can set a primary resume for quick access.
* **AI Match Reports:** Compare your resume against any job description. Grit provides a match score and an actionable plan to improve your chances.
* **Mock Interviews:** Practice for the real thing. Grit generates custom interview questions based on the exact job posting and your personal background.
* **Insightful Dashboard:** View your overall career readiness score, track your application trends, and monitor your success rate over time.

## The TALL Stack Architecture

Grit is built using the highly optimized TALL stack. This ensures a fast, lightweight, and modern user experience.

* **Tailwind CSS:** For beautiful, responsive styling. The design features the Instrument Sans font and a signature orange theme (#e26a35).
* **Alpine.js:** For lightweight frontend interactions, animations, and dropdowns.
* **Laravel (PHP 8.4):** The core backend framework handling routing, business logic, and database management.
* **Livewire 3:** For dynamic, reactive components without writing custom JavaScript.

## Integrated Cloud Services

To provide the best performance and features, Grit relies on several industry-leading cloud services.

* **Database (Neon):** We use PostgreSQL hosted on Neon. It utilizes connection pooling for maximum database speed and reliability.
* **Media Storage (Cloudinary):** All user files and PDF resumes are securely uploaded, parsed, and served through Cloudinary for fast retrieval.
* **AI Engine (Groq):** The fast match reports and mock interviews are powered by the Groq API. This provides incredibly quick AI responses for a smooth user experience.

## Production Optimization

Grit is fully optimized for live deployment. The application features advanced database query consolidation to prevent N+1 loading issues. The codebase is fully containerized using Docker, making it perfectly suited for modern, scalable hosting platforms like Render and Vercel.