import React, { useState } from 'react';

const ChevronDown = () => (
    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M19 9l-7 7-7-7"/>
    </svg>
);

const HomeIcon = () => (
    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
);

const SearchIcon = () => (
    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
);

const GlobeIcon = () => (
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="9.5" strokeWidth="1.5"/>
        <path d="M2.5 12h19M12 2.5c-2.5 3-4 6-4 9.5s1.5 6.5 4 9.5M12 2.5c2.5 3 4 6 4 9.5s-1.5 6.5-4 9.5" strokeWidth="1.3"/>
    </svg>
);

const navItems = [
    {
        label: 'Book tickets',
        href: '#',
        dropdown: false,
    },
    {
        label: 'Destinations',
        href: '#',
        dropdown: true,
        intro: { title: 'Destinations', text: 'Temukan destinasi wisata terbaik di Sukabumi, dari alam hingga kuliner.' },
        links: [
            { label: 'Geopark Ciletuh', href: '#' },
            { label: 'Pelabuhan Ratu', href: '#' },
            { label: 'Situ Gunung', href: '#' },
            { label: 'Curug Cikaso', href: '#' },
            { label: 'Pantai Ujung Genteng', href: '#' },
            { label: 'Curug Luhur', href: '#' },
            { label: 'Taman Nasional Gunung Halimun', href: '#' },
            { label: 'Semua Destinasi', href: '#', highlight: true },
        ],
    },
    {
        label: 'Things to do',
        href: '#',
        dropdown: true,
        intro: { title: 'Things to do', text: 'Temukan aktivitas seru dan pengalaman tak terlupakan di Sukabumi.' },
        links: [
            { label: 'Wisata keluarga', href: '#' },
            { label: 'Kuliner & minuman', href: '#' },
            { label: 'Arung jeram', href: '#' },
            { label: 'Diving & snorkeling', href: '#' },
            { label: 'Hiking & trekking', href: '#' },
            { label: 'Wisata sejarah', href: '#' },
            { label: 'Belanja oleh-oleh', href: '#' },
            { label: 'Semua aktivitas', href: '#', highlight: true },
        ],
    },
    {
        label: 'Traveller information',
        href: '#',
        dropdown: true,
        intro: { title: 'Traveller information', text: 'Panduan perjalanan lengkap untuk wisatawan Sukabumi.' },
        links: [
            { label: 'Cara ke Sukabumi', href: '#' },
            { label: 'Transportasi lokal', href: '#' },
            { label: 'Aksesibilitas', href: '#' },
            { label: 'Cari hotel', href: '#' },
            { label: 'Informasi penting', href: '#' },
            { label: 'Semua info perjalanan', href: '#', highlight: true },
        ],
    },
    {
        label: 'Accommodation',
        href: '#',
        dropdown: false,
    },
    {
        label: 'Blog',
        href: '#',
        dropdown: false,
    },
];

export default function Navbar() {
    const [searchOpen, setSearchOpen] = useState(false);

    return (
        <header className="bg-white sticky top-0 z-50">

            {/* ── ROW 1: Brand bar ── */}
            <div className="vs-brand-row">

                {/* Left: Language + Currency */}
                <div className="flex items-center gap-3 z-10">
                    <button className="flex items-center gap-1 text-[13px] font-semibold text-gray-700 hover:text-[#1a6bbf] transition-colors">
                        <GlobeIcon />
                        <span>EN</span>
                        <ChevronDown />
                    </button>
                    <button className="flex items-center gap-1 text-[13px] font-semibold text-gray-700 hover:text-[#1a6bbf] transition-colors">
                        <span>Rp&ensp;IDR</span>
                        <ChevronDown />
                    </button>
                </div>

                {/* Center: Brand — truly centered with absolute positioning */}
                <a
                    href="/"
                    className="absolute left-0 right-0 mx-auto w-fit flex flex-col items-center text-center group"
                >
                    <span className="font-black text-[30px] tracking-[0.06em] text-[#1a6bbf] uppercase leading-none group-hover:opacity-80 transition-opacity">
                        Visit Sukabumi
                    </span>
                    <span className="text-[9px] font-bold tracking-[0.22em] text-gray-500 uppercase mt-[3px]">
                        Official Visitor Guide
                    </span>
                </a>

                {/* Right: Search */}
                <form
                    className="flex items-center border border-gray-300 rounded-sm px-2.5 py-[5px] gap-2 focus-within:border-[#1a6bbf] transition-colors z-10"
                    action="/search"
                >
                    <input
                        type="search"
                        name="keywords"
                        placeholder="Search"
                        className="text-[13px] text-gray-700 bg-transparent outline-none w-[130px] placeholder-gray-400"
                    />
                    <button type="submit" className="text-gray-400 hover:text-[#1a6bbf] flex-shrink-0">
                        <SearchIcon />
                    </button>
                </form>

            </div>

            {/* ── ROW 2: Nav bar with megamenu ── */}
            <div className="vs-nav-row">
                <nav className="max-w-7xl mx-auto px-6 w-full flex items-center justify-center">

                    {/* Home */}
                    <a href="/" className="vs-nav-link vs-nav-link-home flex items-center justify-center">
                        <HomeIcon />
                    </a>

                    {navItems.map((item) =>
                        item.dropdown ? (
                            <div key={item.label} className="vs-nav-item relative">
                                <a href={item.href} className="vs-nav-link">
                                    {item.label}
                                    <ChevronDown />
                                </a>
                                <div className="vs-megamenu">
                                    <div className="vs-megamenu-inner">
                                        <div className="vs-megamenu-sidebar">
                                            <div className="vs-megamenu-title">{item.intro.title}</div>
                                            <div className="vs-megamenu-text">{item.intro.text}</div>
                                        </div>
                                        <ul className="vs-megamenu-links">
                                            {item.links.map((link) => (
                                                <li key={link.label}>
                                                    <a
                                                        href={link.href}
                                                        className={link.highlight ? 'vs-highlight' : ''}
                                                    >
                                                        {link.label}
                                                    </a>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        ) : (
                            <a key={item.label} href={item.href} className="vs-nav-link">
                                {item.label}
                            </a>
                        )
                    )}

                </nav>
            </div>

        </header>
    );
}
