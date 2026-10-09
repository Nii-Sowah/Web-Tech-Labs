# Web-Tech-Labs

<!-- START_TIMESTAMP -->2026-10-09 11:47:58 UTC<!-- END_TIMESTAMP -->

## Table of Contents
<!-- START_TOC -->
- [Table of Contents](#table-of-contents)
- [Repository Statistics](#repository-statistics)
- [Repository structure](#repository-structure)
- [Labs completed](#labs-completed)
- [How to view a lab](#how-to-view-a-lab)
- [Adding a new lab](#adding-a-new-lab)
- [Course](#course)
- [License](#license)
<!-- END_TOC -->

## Repository Statistics
<!-- START_STATS -->
- **Total Commits:** 30
- **Project Files Tracked:** 21
<!-- END_STATS -->

# HTML & CSS Course Labs

This repository contains my completed labs and exercises for the HTML/CSS course, based on the [web.dev Learn HTML](https://web.dev/learn/html) curriculum. Each folder corresponds to a lesson topic and includes a working HTML/CSS example built while studying that lesson's concepts.

## Repository structure

```
/
├── lesson-04-links-tables-images/
│   ├── class-schedule.html
│   └── README.md
├── lesson-07-box-model-responsive/
│   ├── index.html
│   ├── styles.css
│   └── README.md
└── README.md          (this file)
```

Each lab folder contains its own short README describing what it demonstrates, plus the source files for that lab.

## Labs completed

| Lesson | Topic | Folder | Concepts covered |
| --- | --- | --- | --- |
| 4 | Links, Tables, Images | [`lesson-04-links-tables-images`](./lesson-04-links-tables-images) | `<a>` hrefs (absolute, relative, fragment, `mailto:`, `tel:`), `target`, `rel`; `<table>` structure (`<thead>`/`<tbody>`, `scope`, `colspan`/`rowspan`); `<img>` with meaningful `alt` text |
| 7 | The Box Model, Responsive Web Design | [`lesson-07-box-model-responsive`](./lesson-07-box-model-responsive) | Standard vs. alternative box model (`box-sizing`), margin collapsing, block/inline/inline-block, media queries, mobile-first breakpoints, responsive images, viewport-based typography |

> This table is updated as new labs are added — see [Adding a new lab](#adding-a-new-lab) below.

## How to view a lab

Each lab is a self-contained static site. Clone the repo and open the lab's `.html` file directly in a browser:

```bash
git clone https://github.com/<your-username>/<repo-name>.git
cd <repo-name>/lesson-XX-topic-name
open index.html   # or class-schedule.html, etc.
```

No build step or server is required — all labs use plain HTML, CSS, and (where relevant) inline/self-contained assets.

## Adding a new lab

1. Create a new folder: `lesson-NN-short-topic-name/`
2. Add the lab's HTML/CSS (and any other assets) inside it
3. Add a short `README.md` inside that folder describing what the lab demonstrates
4. Add a row to the **Labs completed** table above

## Course

These labs follow the HTML learning path from [web.dev/learn/html](https://web.dev/learn/html), covering semantic HTML, forms, accessibility, the box model, and responsive design.

## License

Coursework for personal learning purposes.

