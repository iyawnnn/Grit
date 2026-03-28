# @grit-design
Description: The official frontend design system and UI/UX rules for the Grit project.

## Brand Guidelines
* Color Palette: 
  - Primary Accent: Soft Orange (#FF8A5B)
  - Button Hover: Deep Warm Orange (#E57A4E)
  - Background: Alabaster (#FAF8F5)
  - Text Primary: Ink Black (#2D2A26)
  - Text Muted: Stone Gray (#858079)
* Typography: Use the 'Inter' font family exclusively for all headings and body text.
* Layout: Default to clean, editorial, mobile-first designs. Use split-screen layouts for authentication pages.

## Tech Stack Constraints
* Framework: Strictly use Tailwind CSS v4. 
* Implementation: Rely on native semantic utility classes. Do not use arbitrary values (e.g., `w-[32px]`), heavy box-shadows, or glassmorphism.
* Assets: All images must include SEO-optimized `alt` text.
* Components: Use standard Blade components for repeatable UI elements.