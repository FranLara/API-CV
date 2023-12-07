import './bootstrap';
import Typed from 'typed.js';
import.meta.glob(['../images/**']);

const typed = new Typed('#element', {
  strings: ['<i>First</i> sentence.', '&amp; a second sentence.'],
  typeSpeed: 50,
});