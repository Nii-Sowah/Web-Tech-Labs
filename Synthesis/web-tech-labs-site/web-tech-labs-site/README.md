# Web Tech Labs site

A multi-page showcase built from the labs in this repo, using plain HTML, CSS and JavaScript. No build step.

## Run it
Open `index.html` in a browser.

## Pages (hash-routed, all in index.html)
Home (box-model playground), Schedule, Workshop sign-up, Responsive lab, Forms lab, Gallery, Quiz, Progress.

## Adding a lab
- Edit the progress list at the bottom of `script.js`.
- Add a card to the `cards` list in `script.js`, and a `<section class="page" id="...">` in `index.html`.

Uses Google Fonts (Bricolage Grotesque) with a system fallback, so it also works offline.
