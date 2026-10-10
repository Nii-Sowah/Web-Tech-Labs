const $ = (s) => document.querySelector(s);

/* theme */
$('#theme').onclick = () => {
  const r = document.documentElement;
  const d = matchMedia('(prefers-color-scheme: dark)').matches;
  const cur = r.dataset.theme || (d ? 'dark' : 'light');
  r.dataset.theme = cur === 'dark' ? 'light' : 'dark';
};

/* box model playground */
let bs = 'content-box';
const W = 150;
const D = 230;

function box() {
  const m = +$('#rm').value;
  const b = +$('#rb').value;
  const p = +$('#rp').value;

  ['m', 'b', 'p'].forEach(
    (k) => ($('#o' + k).textContent = $('#r' + k).value)
  );

  const cw = bs === 'content-box' ? W : Math.max(0, D - 2 * p - 2 * b);
  const total = cw + 2 * p + 2 * b;

  $('#L-m').style.padding = m + 'px';
  $('#L-b').style.padding = b + 'px';
  $('#L-p').style.padding = p + 'px';

  const c = $('#L-c');
  c.style.width = cw + 'px';
  c.style.height = '60px';

  $('#read').textContent =
    bs === 'content-box'
      ? `content-box: width ${W}px + padding ${2 * p} + border ${2 * b} = ${total}px on screen.`
      : `border-box: width stays ${D}px, so the content shrinks to ${cw}px.`;
}

document.querySelectorAll('.ctrl input').forEach((i) => {
  i.oninput = box;
});

document.querySelectorAll('[data-bs]').forEach((btn) => {
  btn.onclick = () => {
    bs = btn.dataset.bs;
    document.querySelectorAll('[data-bs]').forEach((x) => {
      x.setAttribute('aria-pressed', x === btn);
    });
    box();
  };
});

box();

/* schedule from data: table + fragment links */
const courses = {
  web: [
    'Web Technologies',
    'Prof. Kofi Kwakye',
    'Mon/Wed/Fri 8:00-9:00 AM',
    'Room 204',
    'k.kwakye@example.edu',
    '8005550142',
  ],
  fin: [
    'Finance for Non-Finance',
    'Prof. Jane Doe',
    'Mon/Tue/Thu 9:00-10:00 AM',
    'Room 118',
    'j.doe@example.edu',
    '8005550198',
  ],
  sys: [
    'Systems Analysis & Design',
    'Prof. Ama Ntim',
    'Tue/Wed/Fri 10:00-11:00 AM',
    'Lab 3',
    'a.ntim@example.edu',
    '8005550176',
  ],
  lead: [
    'Leadership 4',
    'Prof. John Doe',
    'Mon/Wed 12:00-1:00 PM',
    'Room 204',
    'j.doe@example.edu',
    '8005550213',
  ],
};

const grid = [
  ['8:00-9:00', 'web', '', 'web', '', 'web'],
  ['9:00-10:00', 'fin', 'fin', '', 'fin', ''],
  ['10:00-11:00', '', 'sys', 'sys', '', 'sys'],
  ['11:00-12:00', 'Lunch break'],
  ['12:00-1:00', 'lead', '', 'lead', '', ''],
];

function el(t, props = {}, kids = []) {
  const e = document.createElement(t);
  Object.assign(e, props);
  kids.forEach((k) => e.append(k));
  return e;
}

grid.forEach((r) => {
  const tr = el('tr', {}, [el('th', { scope: 'row', textContent: r[0] })]);

  if (r.length === 2) {
    tr.append(el('td', { colSpan: 5, textContent: r[1] }));
  } else {
    r.slice(1).forEach((k) => {
      tr.append(
        k
          ? el('td', {}, [
              el('a', {
                href: '#' + k,
                textContent: courses[k][0],
              }),
            ])
          : el('td', { textContent: '-' })
      );
    });
  }

  $('#rows').append(tr);
});

Object.entries(courses).forEach(([id, c]) =>
  $('#courses').append(
    el('article', { id, className: 'course' }, [
      el('h3', { textContent: c[0] }),
      el('p', { textContent: `${c[1]}, ${c[2]}, ${c[3]}` }),
      el('a', { href: 'mailto:' + c[4], textContent: 'Email professor' }),
      document.createTextNode(' | '),
      el('a', { href: 'tel:' + c[5], textContent: 'Call' }),
    ])
  )
);

/* form: validation + DOM-built confirmation (textContent, so input is never parsed as HTML) */
const f = $('#f');
const bio = $('#bio');

bio.oninput = () => {
  $('#cnt').textContent = `${bio.maxLength - bio.value.length} characters left`;
};

f.querySelectorAll('input,textarea').forEach((e) => {
  e.addEventListener('blur', () => e.classList.add('touched'));
});

f.onsubmit = (ev) => {
  ev.preventDefault();
  f.querySelectorAll('input,textarea').forEach((e) => {
    e.classList.add('touched');
  });

  if (!f.checkValidity()) {
    f.reportValidity();
    return;
  }

  const d = new FormData(f);
  const t = d.getAll('topics');
  const sum = $('#sum');
  sum.replaceChildren();

  [
    ['Name', d.get('name')],
    ['Email', d.get('email')],
    ['Phone', d.get('phone') || '-'],
    ['Level', d.get('level')],
    ['Topics', t.length ? t.join(', ') : 'None selected'],
    ['Notes', d.get('bio') || '-'],
  ].forEach(([k, v]) => {
    sum.append(el('dt', { textContent: k }), el('dd', { textContent: v }));
  });

  f.style.display = 'none';
  $('#done').style.display = 'block';
  $('#done').focus();
};

$('#again').onclick = () => {
  f.reset();
  f.querySelectorAll('.touched').forEach((e) =>
    e.classList.remove('touched')
  );
  bio.oninput();
  f.style.display = 'grid';
  $('#done').style.display = 'none';
};

/* lab progress: edit this list as the repo grows */
[
  ['Lesson 3', 'Headings, images, alt text (Gallery)', 'done'],
  ['Lesson 4', 'Links and tables (Schedule)', 'done'],
  ['Lesson 5', 'Forms and HTML APIs notes (Forms lab)', 'done'],
  ['Lesson 6', 'Forms and DOM sign-up (Workshop)', 'done'],
  ['Lesson 7', 'Box model and responsive (Home, Responsive)', 'done'],
  ['Lessons 1 and 2', 'Folder exists, I could not open it', 'unread'],
  ['Lessons 8 to 11', 'Empty files in the repo, no content yet', 'waiting'],
].forEach(([a, b, s]) => {
  const li = el('li', {}, [
    el('b', { textContent: a }),
    el('span', { textContent: b }),
  ]);
  li.dataset.s = s;
  $('#labs').append(li);
});

/* router: pages by hash; other hashes (course ids) open their page and scroll */
const pages = [...document.querySelectorAll('.page')];

function route() {
  const id = location.hash.slice(1) || 'home';
  let pg = pages.find((p) => p.id === id);
  let target = null;

  if (!pg) {
    target = document.getElementById(id);
    pg = (target && target.closest('.page')) || pages[0];
  }

  pages.forEach((p) => p.classList.toggle('on', p === pg));
  document.querySelectorAll('nav a').forEach((a) => {
    a.toggleAttribute('aria-current', a.hash === '#' + pg.id) ||
      a.removeAttribute('aria-current');
  });
  document
    .querySelectorAll('nav a[aria-current]')
    .forEach((a) => a.setAttribute('aria-current', 'page'));

  if (target) {
    target.scrollIntoView();
  } else {
    scrollTo(0, 0);
  }

  if (pg.id === 'responsive') {
    vw();
  }
}

addEventListener('hashchange', route);

/* home cards */
[
  ['schedule', 'Class schedule', 'Tables, fragment, mailto and tel links'],
  ['signup', 'Workshop sign-up', 'Forms, validation, DOM'],
  ['responsive', 'Responsive lab', 'Container queries, clamp(), display types'],
  ['forms', 'Forms lab', 'Live ValidityState'],
  ['gallery', 'Gallery', 'Figures, alt text, filtering'],
  ['quiz', 'Concept quiz', 'Test what the labs covered'],
].forEach(([id, t, d]) =>
  $('#cards').append(
    el('a', { href: '#' + id, className: 'card' }, [
      el('b', { textContent: t }),
      el('span', { textContent: d }),
    ])
  )
);

/* responsive lab */
const fr = $('#frame');

function bp() {
  const w = fr.clientWidth;
  $('#bp').textContent = `Frame content is ${Math.round(w - 24)}px wide: ${
    w >= 640 + 24 ? '3' : w >= 420 + 24 ? '2' : '1'
  } column(s).`;
}

function vw() {
  $('#vw').textContent = innerWidth;
  bp();
}

$('#fw').oninput = (e) => {
  fr.style.width = e.target.value + 'px';
  $('#fo').textContent = e.target.value;
  bp();
};

fr.style.width = '700px';
new ResizeObserver(bp).observe(fr);
addEventListener('resize', vw);

/* forms lab */
const kinds = {
  email: { type: 'email', required: true },
  num: { type: 'number', min: 1, max: 10, required: true },
  pat: {
    type: 'text',
    pattern: '[A-Z]{3}[0-9]{2}',
    required: true,
  },
  len: { type: 'text', minLength: 4, required: true },
};

const pr = $('#probe');

function setKind() {
  const k = kinds[$('#kind').value];
  ['min', 'max', 'pattern', 'minLength'].forEach((a) =>
    pr.removeAttribute(a)
  );
  pr.type = 'text';
  Object.assign(pr, k);
  pr.value = '';
  chk();
}

function chk() {
  const v = pr.validity;
  $('#flags').replaceChildren(
    ...[
      'valueMissing',
      'typeMismatch',
      'patternMismatch',
      'tooShort',
      'rangeUnderflow',
      'rangeOverflow',
      'badInput',
    ].map((n) =>
      el('span', {
        className: 'flag' + (v[n] ? ' on' : ''),
        textContent: n,
      })
    ),
    el('span', {
      className: 'flag' + (v.valid ? ' ok' : ''),
      textContent: 'valid',
    })
  );
  $('#msg').textContent = v.valid
    ? 'The browser accepts this value.'
    : 'Browser message: ' + pr.validationMessage;
}

$('#kind').onchange = setKind;
pr.oninput = chk;
setKind();

/* gallery: generated SVG images with alt text */
const gal = [
  ['Sunrise over hills', 'nature', '#f6c48b', '#8bb7c6'],
  ['Blue waves', 'nature', '#8bb7c6', '#2f5d8a'],
  ['Green field', 'nature', '#b9d18a', '#6f8f3e'],
  ['Sticky note grid', 'design', '#f5de8a', '#c4473d'],
  ['Dark mode palette', 'design', '#1b222c', '#7fb0dc'],
  ['Warm gradient card', 'design', '#f6c48b', '#c4473d'],
];

const svg = (a, b) =>
  'data:image/svg+xml,' +
  encodeURIComponent(
    `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200"><rect width="300" height="200" fill="${a}"/><circle cx="90" cy="80" r="42" fill="${b}"/><rect x="140" y="110" width="120" height="60" rx="8" fill="${b}" opacity=".6"/></svg>`
  );

function drawGal(tag) {
  $('#gal').replaceChildren(
    ...gal
      .filter((g) => tag === 'all' || g[1] === tag)
      .map((g) =>
        el('figure', {}, [
          el('img', {
            src: svg(g[2], g[3]),
            alt: g[0] + ' (placeholder illustration)',
            width: 300,
            height: 200,
          }),
          el('figcaption', { textContent: g[0] }),
        ])
      )
  );

  document
    .querySelectorAll('#tags button')
    .forEach((b) => b.setAttribute('aria-pressed', b.dataset.t === tag));
}

['all', 'nature', 'design'].forEach((t) => {
  const b = el('button', { type: 'button', textContent: t });
  b.dataset.t = t;
  b.onclick = () => drawGal(t);
  $('#tags').append(b);
});

drawGal('all');

/* quiz */
const Q = [
  [
    'With box-sizing: border-box and width 200px, adding padding makes the element...',
    ['wider than 200px', 'still 200px wide', 'narrower than the border'],
    1,
  ],
  [
    'Which element labels a group of radio buttons?',
    ['legend inside fieldset', 'span', 'caption'],
    0,
  ],
  [
    'What does a fragment link like href="#web" do?',
    ['Opens a new tab', 'Scrolls to the element with id="web"', 'Sends an email'],
    1,
  ],
  [
    'Which method keeps form data out of the URL?',
    ['GET', 'POST', 'HEAD'],
    1,
  ],
];

let qi = 0;
let sc = 0;

function ask() {
  const b = $('#qbox');
  b.replaceChildren();

  if (qi >= Q.length) {
    b.append(el('h3', { textContent: `You scored ${sc} out of ${Q.length}.` }));
    const r = el('button', {
      type: 'button',
      className: 'primary',
      textContent: 'Try again',
    });
    r.onclick = () => {
      qi = 0;
      sc = 0;
      ask();
    };
    b.append(r);
    return;
  }

  const [q, o, a] = Q[qi];
  b.append(
    el('p', {
      textContent: `Question ${qi + 1} of ${Q.length}`,
      className: 'hint',
    }),
    el('h3', { textContent: q })
  );

  o.forEach((t, i) => {
    const x = el('button', {
      type: 'button',
      className: 'opt',
      textContent: t,
    });

    x.onclick = () => {
      b.querySelectorAll('.opt').forEach((y, j) => {
        y.disabled = true;
        if (j === a) {
          y.classList.add('right');
        }
      });

      if (i === a) {
        sc++;
      } else {
        x.classList.add('wrong');
      }

      const n = el('button', {
        type: 'button',
        className: 'primary',
        textContent: qi < Q.length - 1 ? 'Next question' : 'See score',
      });
      n.onclick = () => {
        qi++;
        ask();
      };
      b.append(n);
      n.focus();
    };

    b.append(x);
  });
}

ask();
route();
