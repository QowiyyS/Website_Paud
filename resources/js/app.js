import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.nav-menu-link');
    const sectionIds = ['#beranda', '#tentang', '#program', '#pendaftaran'];
    const sections = sectionIds
        .map(id => document.querySelector(id))
        .filter(Boolean);

    const activeClasses = ['bg-blue-600', 'text-white', 'font-bold', 'shadow-sm', 'hover:bg-blue-700'];
    const inactiveClasses = ['text-slate-600', 'font-semibold', 'hover:bg-orange-100', 'hover:text-orange-700'];

    function setActive(targetHref) {
        if (!targetHref) return;

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === targetHref) {
                link.classList.remove(...inactiveClasses);
                link.classList.add(...activeClasses);
            } else {
                link.classList.remove(...activeClasses);
                link.classList.add(...inactiveClasses);
            }
        });
    }

    // Klik smooth scroll pada link navigasi dan tombol CTA lainnya
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId && targetId !== '#') {
                const targetEl = document.querySelector(targetId);
                if (targetEl) {
                    e.preventDefault();
                    setActive(targetId);
                    targetEl.scrollIntoView({ behavior: 'smooth' });
                    history.pushState(null, '', targetId);
                }
            }
        });
    });

    // ScrollSpy: Deteksi posisi scroll untuk mengaktifkan link yang sesuai secara otomatis
    function onScroll() {
        // Jika sudah dekat bagian paling bawah halaman, aktifkan menu terakhir (#pendaftaran)
        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 70) {
            setActive('#pendaftaran');
            return;
        }

        const scrollPosition = window.scrollY + 180;
        let currentSection = null;

        sections.forEach(section => {
            const top = section.offsetTop;
            const height = section.offsetHeight;
            if (scrollPosition >= top && scrollPosition < top + height) {
                currentSection = '#' + section.id;
            }
        });

        if (currentSection) {
            setActive(currentSection);
        } else if (window.scrollY < 200) {
            setActive('#beranda');
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });

    // Cek posisi awal saat halaman dibuka
    if (window.location.hash && sectionIds.includes(window.location.hash)) {
        setActive(window.location.hash);
    } else {
        onScroll();
    }
});
