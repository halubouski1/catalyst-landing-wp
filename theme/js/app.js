// ========================================
// Vendor bootstrap (ES module)
// ----------------------------------------
// The local vendor files are ESM builds (esm.sh) that `export default`,
// while main.js expects the classic globals `AOS`, `Lenis`, `Swiper`.
// We import them here, expose them on `window`, then load main.js so it
// can run unchanged.
// ========================================
import AOS from './vendor/aos.js';
import Lenis from './vendor/lenis.js';
import Swiper from './vendor/swiper.js';

window.AOS = AOS;
window.Lenis = Lenis;
window.Swiper = Swiper;

// Static imports above are hoisted, so the globals are set before main.js
// runs. A dynamic import keeps main.js execution after that assignment.
// Carry over app.js's ?ver so main.js is cache-busted together with it.
const __ver = new URL(import.meta.url).searchParams.get('ver');
await import('./main.js' + (__ver ? '?ver=' + __ver : ''));
