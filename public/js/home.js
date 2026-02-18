AOS.init({ duration: 1000, once: true, offset: 100 });
const btnMobile = document.getElementById('btn-mobile');
const mobileMenu = document.getElementById('mobileMenu');
const mobileClose = document.getElementById('mobileClose');
const mobileBackdrop = document.getElementById('mobileMenuBackdrop');
if (btnMobile && mobileMenu) { btnMobile.addEventListener('click', () => { mobileMenu.classList.remove('hidden'); }); }
function closeMobileMenu() { mobileMenu.classList.add('hidden'); }
if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileMenu);
document.querySelectorAll('.mobile-nav-link').forEach(link => { link.addEventListener('click', closeMobileMenu); });
document.addEventListener('click', (e) => {
  const likeBtn = e.target.closest('.like-btn');
  if (!likeBtn) return;
  const icon = likeBtn.querySelector('i');
  if (icon.classList.contains('fa-regular')) {
    icon.classList.remove('fa-regular'); icon.classList.add('fa-solid'); icon.classList.add('text-red-500');
  } else {
    icon.classList.remove('fa-solid'); icon.classList.add('fa-regular'); icon.classList.remove('text-red-500');
  }
});
const heroVideo = document.getElementById('heroVideo');
const heroMute = document.getElementById('heroMute');
const heroPlayBtn = document.getElementById('heroPlayBtn');
function setHeroMuteLabel() {
  if (!heroMute) return;
  heroMute.innerHTML = heroVideo && heroVideo.muted ? 'Unmute <i class="fa-solid fa-volume-high ml-2"></i>' : 'Mute <i class="fa-solid fa-volume-xmark ml-2"></i>';
}
function showPlayBtn() { if (heroPlayBtn) heroPlayBtn.classList.remove('hidden'); }
function hidePlayBtn() { if (heroPlayBtn) heroPlayBtn.classList.add('hidden'); }
if (heroVideo) {
  document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      heroVideo.play().then(() => { hidePlayBtn(); }).catch(() => { showPlayBtn(); });
    }, 200);
  });
  heroVideo.addEventListener('pause', () => { showPlayBtn(); });
  heroVideo.addEventListener('playing', () => { hidePlayBtn(); });
  heroVideo.addEventListener('ended', () => { heroVideo.currentTime = 0; heroVideo.play().catch(() => {}); });
  document.addEventListener('visibilitychange', () => { if (!document.hidden) { heroVideo.play().catch(() => { showPlayBtn(); }); } });
  window.addEventListener('focus', () => { heroVideo.play().catch(() => { showPlayBtn(); }); });
  if (heroPlayBtn) {
    heroPlayBtn.addEventListener('click', () => {
      heroVideo.muted = true;
      heroVideo.play().then(() => { hidePlayBtn(); }).catch(() => {});
    });
  }
}
if (heroMute && heroVideo) {
  setHeroMuteLabel();
  heroMute.addEventListener('click', () => {
    heroVideo.muted = !heroVideo.muted;
    setHeroMuteLabel();
    heroVideo.play().catch(() => { showPlayBtn(); });
  });
}
(function () {
  const container = document.getElementById('featuredTrack');
  const track = document.getElementById('featuredTrackInner');
  const prev = document.getElementById('prevFeatured');
  const next = document.getElementById('nextFeatured');
  if (!container || !track || !prev || !next) return;
  const pxPerSecond = 60;
  let running = true;
  let rafId = null;
  let lastTS = null;
  let pausedByInteraction = false;
  function step(ts) {
    if (!lastTS) lastTS = ts;
    const dt = ts - lastTS;
    lastTS = ts;
    if (running) {
      const delta = (pxPerSecond * dt) / 1000;
      const maxScroll = container.scrollWidth - container.clientWidth;
      container.scrollLeft += delta;
      if (container.scrollLeft >= maxScroll - 1) { container.scrollLeft = 0; }
    }
    rafId = requestAnimationFrame(step);
  }
  function startAuto() { running = true; pausedByInteraction = false; lastTS = null; if (!rafId) rafId = requestAnimationFrame(step); }
  function stopAuto() { running = false; }
  startAuto();
  [container, prev, next].forEach(el => {
    el.addEventListener('mouseenter', () => { stopAuto(); pausedByInteraction = true; });
    el.addEventListener('mouseleave', () => { if (pausedByInteraction) startAuto(); });
  });
  track.querySelectorAll('.slide').forEach(s => {
    s.addEventListener('mouseenter', () => { stopAuto(); pausedByInteraction = true; });
    s.addEventListener('mouseleave', () => { if (pausedByInteraction) startAuto(); });
  });
  function getSlideWidth() {
    const slide = track.querySelector('.slide');
    if (!slide) return track.clientWidth;
    const style = window.getComputedStyle(slide);
    const marginRight = parseFloat(style.marginRight) || 0;
    return slide.offsetWidth + marginRight;
  }
  prev.addEventListener('click', () => {
    stopAuto(); pausedByInteraction = true;
    const w = getSlideWidth();
    if (container.scrollLeft === 0) {
      container.scrollTo({ left: container.scrollWidth - container.clientWidth, behavior: 'smooth' });
    } else {
      container.scrollBy({ left: -w, behavior: 'smooth' });
    }
  });
  next.addEventListener('click', () => {
    stopAuto(); pausedByInteraction = true;
    const w = getSlideWidth();
    container.scrollBy({ left: w, behavior: 'smooth' });
  });
  document.addEventListener('visibilitychange', () => { if (document.hidden) stopAuto(); else if (!pausedByInteraction) startAuto(); });
  window.addEventListener('beforeunload', () => { if (rafId) cancelAnimationFrame(rafId); });
})();
(function () {
  const container = document.getElementById('recommendTrack');
  const track = document.getElementById('recommendTrackInner');
  const prev = document.getElementById('prevRecommend');
  const next = document.getElementById('nextRecommend');
  if (!container || !track || !prev || !next) return;
  const pxPerSecond = 50;
  let running = true;
  let rafId = null;
  let lastTS = null;
  let pausedByInteraction = false;
  function step(ts) {
    if (!lastTS) lastTS = ts;
    const dt = ts - lastTS;
    lastTS = ts;
    if (running) {
      const delta = (pxPerSecond * dt) / 1000;
      const maxScroll = container.scrollWidth - container.clientWidth;
      container.scrollLeft += delta;
      if (container.scrollLeft >= maxScroll - 1) { container.scrollLeft = 0; }
    }
    rafId = requestAnimationFrame(step);
  }
  function startAuto() { running = true; pausedByInteraction = false; lastTS = null; if (!rafId) rafId = requestAnimationFrame(step); }
  function stopAuto() { running = false; }
  startAuto();
  [container, prev, next].forEach(el => {
    el.addEventListener('mouseenter', () => { stopAuto(); pausedByInteraction = true; });
    el.addEventListener('mouseleave', () => { if (pausedByInteraction) startAuto(); });
  });
  track.querySelectorAll('.slide').forEach(s => {
    s.addEventListener('mouseenter', () => { stopAuto(); pausedByInteraction = true; });
    s.addEventListener('mouseleave', () => { if (pausedByInteraction) startAuto(); });
  });
  function getSlideWidth() {
    const slide = track.querySelector('.slide');
    if (!slide) return track.clientWidth;
    const style = window.getComputedStyle(slide);
    const marginRight = parseFloat(style.marginRight) || 0;
    return slide.offsetWidth + marginRight;
  }
  prev.addEventListener('click', () => {
    stopAuto(); pausedByInteraction = true;
    const w = getSlideWidth();
    if (container.scrollLeft === 0) {
      container.scrollTo({ left: container.scrollWidth - container.clientWidth, behavior: 'smooth' });
    } else {
      container.scrollBy({ left: -w, behavior: 'smooth' });
    }
  });
  next.addEventListener('click', () => {
    stopAuto(); pausedByInteraction = true;
    const w = getSlideWidth();
    container.scrollBy({ left: w, behavior: 'smooth' });
  });
  document.addEventListener('visibilitychange', () => { if (document.hidden) stopAuto(); else if (!pausedByInteraction) startAuto(); });
  window.addEventListener('beforeunload', () => { if (rafId) cancelAnimationFrame(rafId); });
})();
window.addEventListener('load', () => {
  const popup = document.getElementById('promoPopup');
  const content = document.getElementById('promoContent');
  const closePromo = document.getElementById('closePromo');
  const closePromoBtn = document.getElementById('closePromoBtn');
  const promoBackdrop = document.getElementById('promoBackdrop');
  const promoAction = document.getElementById('promoAction');
  setTimeout(() => {
    if (!popup || !content) return;
    popup.classList.remove('hidden');
    popup.classList.add('flex');
    void content.offsetWidth;
    content.classList.remove('scale-95', 'opacity-0');
    content.classList.add('scale-100', 'opacity-100');
  }, 500);
  function hidePopup() {
    if (!popup || !content) return;
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
      popup.classList.add('hidden');
      popup.classList.remove('flex');
    }, 500);
  }
  [closePromo, closePromoBtn, promoBackdrop, promoAction].forEach(btn => { if (btn) btn.addEventListener('click', hidePopup); });
});
