const clamp = (min, value, max) => Math.min(max, Math.max(min, value));
const body = document.body;
const intro = document.querySelector('#intro');
const startJourney = document.querySelector('#startJourney');
const world = document.querySelector('#world');
const journey = document.querySelector('#journey');
const car = document.querySelector('#car');
const progressBar = document.querySelector('#routeProgress');
const kilometer = document.querySelector('#kilometer');
const instruction = document.querySelector('#scrollInstruction');
const soundToggle = document.querySelector('#soundToggle');
const driveForward = document.querySelector('#driveForward');
const driveBack = document.querySelector('#driveBack');
const mapDialog = document.querySelector('#mapDialog');
const placeDialog = document.querySelector('#placeDialog');
let audio = null;
let driveFrame = null;
let lastScroll = 0;
let hideInstructionTimer = null;

function createJourneyAudio() {
  const AudioContext = window.AudioContext || window.webkitAudioContext;
  if (!AudioContext) return null;
  const context = new AudioContext();
  const master = context.createGain();
  const filter = context.createBiquadFilter();
  const sampleCount = context.sampleRate * 2;
  const buffer = context.createBuffer(1, sampleCount, context.sampleRate);
  const channel = buffer.getChannelData(0);
  for (let i = 0; i < sampleCount; i++) channel[i] = (Math.random() * 2 - 1) * .18;
  const breeze = context.createBufferSource();
  breeze.buffer = buffer;
  breeze.loop = true;
  filter.type = 'lowpass';
  filter.frequency.value = 640;
  master.gain.value = .026;
  breeze.connect(filter).connect(master).connect(context.destination);
  breeze.start();
  return { context, master };
}

function startAudio() {
  audio ??= createJourneyAudio();
  if (!audio) return;
  audio.context.resume();
  audio.master.gain.setTargetAtTime(.026, audio.context.currentTime, .2);
}

function setSound(enabled) {
  soundToggle.setAttribute('aria-pressed', String(enabled));
  soundToggle.setAttribute('aria-label', enabled ? 'Matikan suara' : 'Aktifkan suara');
  soundToggle.querySelector('span').textContent = enabled ? ')))' : '×';
  if (enabled) startAudio();
  else if (audio) audio.master.gain.setTargetAtTime(0, audio.context.currentTime, .12);
}

function updateWorld() {
  const maxVertical = journey.offsetHeight - innerHeight;
  const localY = clamp(0, scrollY - journey.offsetTop, maxVertical);
  const progress = maxVertical > 0 ? localY / maxVertical : 0;
  const maxTravel = world.scrollWidth - innerWidth;
  world.style.transform = `translate3d(${-progress * maxTravel}px,0,0)`;
  document.querySelector('.sky').style.backgroundPosition = `${progress * 100}% 50%`;
  progressBar.style.width = `${progress * 100}%`;
  kilometer.textContent = Math.round(progress * 120);
  car.classList.toggle('driving', Math.abs(scrollY - lastScroll) > 1);
  lastScroll = scrollY;
  instruction.classList.add('hide');
  clearTimeout(hideInstructionTimer);
  hideInstructionTimer = setTimeout(() => {
    if (progress < .98) instruction.classList.remove('hide');
  }, 1500);
}

function beginJourney() {
  intro.classList.add('hidden');
  body.classList.remove('is-intro');
  setSound(true);
  setTimeout(() => {
    intro.setAttribute('aria-hidden', 'true');
    window.scrollTo({ top: journey.offsetTop + 2, behavior: 'smooth' });
  }, 300);
}

function drive(direction) {
  const step = Math.max(8, innerHeight * .012) * direction;
  window.scrollBy(0, step);
  driveFrame = requestAnimationFrame(() => drive(direction));
}

function stopDrive() {
  if (driveFrame) cancelAnimationFrame(driveFrame);
  driveFrame = null;
}

function bindHold(button, direction) {
  button.addEventListener('pointerdown', event => {
    event.preventDefault();
    stopDrive();
    button.setPointerCapture?.(event.pointerId);
    drive(direction);
  });
  button.addEventListener('pointerup', stopDrive);
  button.addEventListener('pointercancel', stopDrive);
  button.addEventListener('lostpointercapture', stopDrive);
  button.addEventListener('keydown', event => {
    if ((event.key === 'Enter' || event.key === ' ') && !driveFrame) drive(direction);
  });
  button.addEventListener('keyup', stopDrive);
}

function openMap() {
  if (typeof mapDialog.showModal === 'function') mapDialog.showModal();
}

startJourney.addEventListener('click', beginJourney);
soundToggle.addEventListener('click', () => setSound(soundToggle.getAttribute('aria-pressed') !== 'true'));
document.querySelector('#openMap').addEventListener('click', openMap);
document.querySelector('#mapFromBoard').addEventListener('click', openMap);
document.querySelector('#closeMap').addEventListener('click', () => mapDialog.close());
const closePlace = document.querySelector('#closePlace');
const placeDismiss = document.querySelector('#placeDismiss');
const placeImage = document.querySelector('#placeImage');
const placeCategory = document.querySelector('#placeCategory');
const placeName = document.querySelector('#placeName');
const placeDescription = document.querySelector('#placeDescription');
const placeLink = document.querySelector('#placeLink');

function openPlaceModal(data) {
  if (placeName) placeName.textContent = data.name || 'Destinasi';
  if (placeCategory) placeCategory.textContent = data.category || 'DESTINASI SUKABUMI';
  if (placeDescription) placeDescription.textContent = data.desc || 'Informasi destinasi wisata di Sukabumi.';
  if (placeImage) {
    placeImage.src = data.img || 'assets/destinations/kawah-ratu.webp';
    placeImage.alt = data.name || 'Destinasi';
  }
  if (placeLink) {
    placeLink.href = data.url || '#';
    placeLink.target = '_blank';
    placeLink.rel = 'noopener noreferrer';
  }
  if (typeof placeDialog.showModal === 'function') {
    placeDialog.showModal();
  }
}

if (closePlace) closePlace.addEventListener('click', () => placeDialog.close());
if (placeDismiss) placeDismiss.addEventListener('click', () => placeDialog.close());
mapDialog.addEventListener('click', event => { if (event.target === mapDialog) mapDialog.close(); });
placeDialog.addEventListener('click', event => { if (event.target === placeDialog) placeDialog.close(); });

document.querySelectorAll('.destination-card').forEach(card => {
  card.addEventListener('click', event => {
    event.preventDefault();
    openPlaceModal({
      name: card.dataset.name,
      category: card.dataset.category,
      desc: card.dataset.desc,
      img: card.dataset.img,
      url: card.dataset.url
    });
  });
});

document.querySelectorAll('[data-place]').forEach(button => {
  button.addEventListener('click', () => {
    openPlaceModal({
      name: button.dataset.place,
      category: 'KABUPATEN SUKABUMI',
      desc: 'Destinasi ini akan menjadi bab perjalanan tersendiri pada rute berikutnya.',
      img: '/assets/images/3.jpg',
      url: 'https://www.visitsukabumi.com/place?q=' + encodeURIComponent(button.dataset.place)
    });
  });
});

bindHold(driveForward, 1);
bindHold(driveBack, -1);
addEventListener('scroll', () => requestAnimationFrame(updateWorld), { passive: true });
addEventListener('resize', updateWorld);
updateWorld();
