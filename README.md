# Web-Tech-Labs

<!-- START_TIMESTAMP -->2026-10-15 01:43:39 UTC<!-- END_TIMESTAMP -->

## Table of Contents
<!-- START_TOC -->
- [Table of Contents](#table-of-contents)
- [Repository Statistics](#repository-statistics)
- [About](#about)
- [Repository structure](#repository-structure)
- [Labs and projects](#labs-and-projects)
- [Running the labs](#running-the-labs)
- [Working with the PHP lab](#working-with-the-php-lab)
- [Adding a lab](#adding-a-lab)
- [Course](#course)
- [License](#license)
<!-- END_TOC -->

## Repository Statistics
<!-- START_STATS -->
- **Total Commits:** 62
- **Project Files Tracked:** 29
<!-- END_STATS -->

## About

This repository contains completed labs and exercises from a web technologies
course. The examples progress from HTML structure and CSS layout to forms,
JavaScript, the DOM, asynchronous requests, and a PHP/MySQL application.

Most labs are intentionally small, self-contained examples that can be opened
directly in a browser. The [`Synthesis`](./Synthesis) project combines the
coursework into a single interactive showcase.

## Repository structure

```text
.
├── Lesson 1 and 2/        # PHP/MySQL habit tracker
├── lesson-3-lab.html      # Introductory HTML lab
├── lesson_4_lab.html      # Links, tables, images, and schedule
├── Lesson 5(actually 6).html
│                           # Forms and HTML APIs
├── Lesson 6(actually 5).html
│                           # Forms, validation, and the DOM
├── lesson_7/              # CSS box model and responsive layout
├── lesson_8/              # JavaScript arrays, objects, and order totals
├── lesson_9/              # JavaScript types, conditions, and objects
├── lesson_10/             # XMLHttpRequest and external data
├── lesson_11/             # XML/JSON menu and order requests
└── Synthesis/             # Combined multi-page showcase
```

## Labs and projects

| Lab or project | What it demonstrates |
| --- | --- |
| [`Lesson 1 and 2`](./Lesson%201%20and%202) | A PHP/MySQL habit tracker with CRUD-style API actions, database schema, and a browser UI. |
| [`lesson-3-lab.html`](./lesson-3-lab.html) | Basic HTML structure, headings, links, images, and page content. |
| [`lesson_4_lab.html`](./lesson_4_lab.html) | Accessible tables, links, fragments, and a class schedule. |
| [`Lesson 5(actually 6).html`](./Lesson%205%28actually%206%29.html) | Forms, controls, built-in validation, and HTML APIs. |
| [`Lesson 6(actually 5).html`](./Lesson%206%28actually%205%29.html) | A live form workshop using validation, CSS state selectors, and DOM updates. |
| [`lesson_7`](./lesson_7) | CSS box sizing, margin collapsing, layout modes, responsive images, and media queries. |
| [`lesson_8`](./lesson_8) | JavaScript arrays, objects, functions, constructors, classes, and order calculations. |
| [`lesson_9`](./lesson_9) | JavaScript variables, types, comparisons, conditions, objects, and dynamic content. |
| [`lesson_10`](./lesson_10) | Loading menu data asynchronously with `XMLHttpRequest`. |
| [`lesson_11`](./lesson_11) | Reading XML and JSON menu data and submitting an order request. |
| [`Synthesis`](./Synthesis) | A hash-routed showcase containing the schedule, forms, responsive, gallery, quiz, and progress experiences. |

## Running the labs

The standalone HTML labs do not require a build tool or package installation.
Clone the repository and open the relevant file or `index.html` in a browser:

```bash
git clone https://github.com/Nii-Sowah/Web-Tech-Labs.git
cd Web-Tech-Labs
```

You can then open, for example:

- [`lesson_4_lab.html`](./lesson_4_lab.html)
- [`lesson_7/index.html`](./lesson_7/index.html)
- [`Synthesis/index.html`](./Synthesis/index.html)

The labs that use `fetch` or `XMLHttpRequest` should be served from a local
HTTP server rather than opened with a `file://` URL. For example, if Python is
installed:

```bash
python -m http.server 8000
```

Visit `http://localhost:8000/` and open the lab from there.

## Working with the PHP lab

The [`Lesson 1 and 2`](./Lesson%201%20and%202) project requires PHP, MySQL, and
a web server. To set it up:

1. Create the database and tables using [`database.sql`](./Lesson%201%20and%202/database.sql).
2. Update the database credentials in [`config.php`](./Lesson%201%20and%202/config.php).
3. Serve the directory through Apache, Nginx, XAMPP, or PHP's development server.
4. Open [`index.php`](./Lesson%201%20and%202/index.php) in a browser.

The PHP API is implemented in [`api.php`](./Lesson%201%20and%202/api.php), and
the frontend uses [`script.js`](./Lesson%201%20and%202/script.js) and
[`style.css`](./Lesson%201%20and%202/style.css).

## Adding a lab

1. Add the lab source files to a clearly named directory or root-level file.
2. Prefer a local `README.md` when the lab needs setup or usage instructions.
3. Add the lab to the **Labs and projects** table above.
4. Update the repository structure block if the top-level layout changes.

## Course

The labs follow topics from the [web.dev Learn HTML](https://web.dev/learn/html)
curriculum and related web development lessons, including semantic HTML,
forms, accessibility, CSS layout, responsive design, JavaScript, and the DOM.

## License

Coursework for personal learning purposes.
