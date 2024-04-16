import './bootstrap';
import Typed from 'typed.js';
import.meta.glob(['../images/**']);

const typed = new Typed('#welcome', {
  strings: [''],
  typeSpeed: 300,
  loop: true
});

window.setWelcomeMessage = function(message) {
  typed.strings = [message];
}