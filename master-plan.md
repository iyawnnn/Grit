# Project Grit: Master Plan (MVP)

## 1. Database Schema (Source of Truth)

### Table: users
| Field | Type | Purpose |
| :--- | :--- | :--- |
| id | bigint (PK) | Unique ID |
| name | string | User's full name |
| email | string (Unique) | User's email address |
| google_id | string (Unique) | The unique ID returned by Google |
| avatar | string | URL to Google profile picture |
| password | string (Nullable) | Nullable because of OAuth |
| api_token | string (Unique) | Key used for Chrome Extension authentication |
| remember_token | string | Standard Laravel session token |

### Table: resumes
| Field | Type | Purpose |
| :--- | :--- | :--- |
| id | bigint (PK) | Unique ID |
| user_id | foreignId | Links to users.id |
| label | string | Examples include "Full-Stack v1" |
| file_url | string | Cloudinary URL to the PDF |
| content_raw | longText | The actual text extracted from the PDF |
| created_at | timestamp | Upload date |
| is_active | boolean | Marks the default resume for matching |

### Table: job_postings
| Field | Type | Purpose |
| :--- | :--- | :--- |
| id | bigint (PK) | Unique ID |
| user_id | foreignId | Links to users.id |
| title | string | Job Title (such as "Web Developer") |
| company | string | Company Name (such as "Shore360") |
| description | longText | The full text of the job post |
| source_url | string | URL where the job was found |
| status | enum | Choices include draft, applied, interview, rejected, or offer |

### Table: match_reports
| Field | Type | Purpose |
| :--- | :--- | :--- |
| id | bigint (PK) | Unique ID |
| resume_id | foreignId | Which resume was analyzed? |
| job_id | foreignId | Which job was analyzed? |
| score | integer | 0 to 100 percentage |
| missing_keywords | json | List of words in Job but not in Resume |

## 2. Core V1 Logic (Keyword Gap Analysis)
The engine is a logic-based PHP service (MatchService). It uses string matching to find technical skills present in the job description but missing from the resume. 

## 3. Key Integrations
- Auth: Laravel Socialite for Google OAuth 2.0.
- Storage: Cloudinary for PDF resume files.
- PDF Extraction: Spatie PDF-to-Text using the binary in the bin folder.
- UI: Filament PHP v3 for the dashboard.