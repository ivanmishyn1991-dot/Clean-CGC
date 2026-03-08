const $ = s => document.querySelector(s);

/* burger/nav */
let nav = null;
let burger = null;

const setBurgerState = (open) => {
    if (!burger || !nav) return;
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    nav.classList.toggle('open', open);
};

window.addEventListener('load', () => {
    nav = $('#main-nav');
    burger = document.querySelector('.hamburger');

    if (burger && nav){
        burger.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            setBurgerState(!nav.classList.contains('open'));
        });

        nav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setBurgerState(false)));

        document.addEventListener('click', (e) => {
            if (!nav.classList.contains('open')) return;
            const clickedInside = nav.contains(e.target) || burger.contains(e.target);
            if (!clickedInside) setBurgerState(false);
        });
    }
});

/* desktop phone: click copies phone + badge */
(function(){
    const phoneBtn = $('#headerPhoneBtn');
    const badge = $('#copiedBadge');
    const phoneToCopy = '+1 (672) 500-6060';

    let badgeTimer = null;

    function showBadge(){
        if (!badge) return;
        badge.classList.add('show');
        if (badgeTimer) clearTimeout(badgeTimer);
        badgeTimer = setTimeout(() => badge.classList.remove('show'), 1600);
    }

    if (!phoneBtn) return;

    phoneBtn.addEventListener('click', async (e) => {
        const isDesktop = window.matchMedia('(min-width: 861px)').matches;
        if (!isDesktop) return; // mobile keeps tel:
        e.preventDefault();

        try{
            await navigator.clipboard.writeText(phoneToCopy);
            showBadge();
        }catch(err){
            const ta = document.createElement('textarea');
            ta.value = phoneToCopy;
            ta.style.position = 'fixed';
            ta.style.left = '-9999px';
            document.body.appendChild(ta);
            ta.select();
            try{ document.execCommand('copy'); }catch(e2){}
            document.body.removeChild(ta);
            showBadge();
        }
    });
})();

/* robot widget logic */
(function(){
    const wrap = document.getElementById('cgcRobotWrap');
    const btn  = document.getElementById('cgcRobotBtn');
    const hit  = document.getElementById('cgcRobotHit');
    const bubble = document.getElementById('cgcRobotBubble');

    if (!wrap || !btn || !bubble) return;

    const toggle = (e) => {
        e.stopPropagation();
        const isOpen = wrap.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    };

    if (hit) hit.addEventListener('click', toggle);
    btn.addEventListener('click', toggle);

    document.addEventListener('click', (e) => {
        if (!wrap.classList.contains('is-open')) return;
        if (wrap.contains(e.target)) return;
        wrap.classList.remove('is-open');
        btn.setAttribute('aria-expanded', 'false');
    });

    function showBubble(){
        if (wrap.classList.contains('is-open')) return;
        bubble.classList.add('is-visible');
        setTimeout(() => bubble.classList.remove('is-visible'), 2500);
    }

    setTimeout(showBubble, 3000);
    setInterval(showBubble, 10000);
})();

/* photo modal: click opens, second click closes */
(function(){
    const modal = document.getElementById('photoModal');
    const modalImg = document.getElementById('photoModalImg');
    const closeBtn = document.getElementById('photoModalClose');

    if (!modal || !modalImg) return;

    let currentSrc = "";

    function openModal(src, alt){
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
        modalImg.src = src;
        modalImg.alt = alt || 'Photo preview';
        document.body.classList.add('modal-open');
        currentSrc = src;
    }

    function closeModal(){
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
        modalImg.src = "";
        document.body.classList.remove('modal-open');
        currentSrc = "";
    }

    document.addEventListener('click', (e) => {
        const img = e.target.closest('img.work-photo');
        if (!img) return;

        e.preventDefault();
        e.stopPropagation();

        const src = img.getAttribute('src');
        const alt = img.getAttribute('alt') || '';

        if (modal.classList.contains('open') && currentSrc === src){
            closeModal();
            return;
        }

        openModal(src, alt);
    });

    closeBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        closeModal();
    });

    modal.addEventListener('click', (e) => {
        const inner = e.target.closest('.photo-modal-inner');
        if (inner) return;
        closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
    });
})();

/* Services accordion logic (left panel) */
(function(){
    const btn = document.getElementById('servicesAccBtn');
    const panel = document.getElementById('servicesAccPanel');
    if (!btn || !panel) return;

    const setOpen = (open) => {
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        panel.classList.toggle('open', open);
    };

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const isOpen = btn.getAttribute('aria-expanded') === 'true';
        setOpen(!isOpen);
    });
})();