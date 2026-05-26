import { useState, useEffect, useRef } from 'react';
import { Link, useNavigate, useLocation } from 'react-router-dom';

const navItems = [
    { name: 'Dashboard', path: '/', icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-5 h-5">
            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
        </svg>
    )},
    { name: 'Students', path: '/students', icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-5 h-5">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
    )},
    { name: 'Add Student', path: '/students/new', icon: (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-5 h-5">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
        </svg>
    )},
];

export default function Layout({ children }) {
    const navigate = useNavigate();
    const location = useLocation();
    const [sidebarOpen, setSidebarOpen] = useState(true);
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const dropdownRef = useRef(null);

    useEffect(() => {
        const handleClickOutside = (e) => {
            if (dropdownRef.current && !dropdownRef.current.contains(e.target)) {
                setDropdownOpen(false);
            }
        };
        if (dropdownOpen) document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, [dropdownOpen]);

    const user = JSON.parse(localStorage.getItem('user') || '{"name":"Admin"}');

    const handleLogout = () => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        navigate('/login');
    };

    return (
        <div style={{ display: 'flex', minHeight: '100vh', background: '#f0f2f8' }}>
            {/* Sidebar */}
            <aside style={{
                width: sidebarOpen ? '260px' : '72px',
                background: 'linear-gradient(180deg, #1a1d2e 0%, #252840 100%)',
                transition: 'width 0.3s ease',
                display: 'flex',
                flexDirection: 'column',
                position: 'fixed',
                top: 0,
                left: 0,
                bottom: 0,
                zIndex: 50,
                overflow: 'hidden',
                boxShadow: '4px 0 20px rgba(0,0,0,0.15)',
            }}>
                {/* Logo */}
                <div style={{ padding: '24px 20px', display: 'flex', alignItems: 'center', gap: '12px', borderBottom: '1px solid rgba(255,255,255,0.08)' }}>
                    <div style={{
                        width: '36px', height: '36px', borderRadius: '10px', flexShrink: 0,
                        background: 'linear-gradient(135deg, #6366f1, #8b5cf6)',
                        display: 'flex', alignItems: 'center', justifyContent: 'center',
                        fontSize: '16px', fontWeight: '800', color: 'white',
                    }}>S</div>
                    {sidebarOpen && <span style={{ color: 'white', fontWeight: '700', fontSize: '17px', letterSpacing: '-0.3px', whiteSpace: 'nowrap' }}>StudentApp</span>}
                </div>

                {/* Nav */}
                <nav style={{ flex: 1, padding: '16px 12px', overflowY: 'auto' }}>
                    <p style={{ color: 'rgba(255,255,255,0.3)', fontSize: '10px', fontWeight: '600', textTransform: 'uppercase', letterSpacing: '1px', padding: '0 8px 8px', whiteSpace: 'nowrap' }}>
                        {sidebarOpen ? 'Main Menu' : ''}
                    </p>
                    {navItems.map((item) => {
                        const active = location.pathname === item.path;
                        return (
                            <Link key={item.name} to={item.path} style={{
                                display: 'flex', alignItems: 'center', gap: '12px',
                                padding: '10px 12px', borderRadius: '10px', marginBottom: '4px',
                                textDecoration: 'none', whiteSpace: 'nowrap', transition: 'all 0.2s',
                                background: active ? 'linear-gradient(135deg, #6366f1, #8b5cf6)' : 'transparent',
                                color: active ? 'white' : 'rgba(255,255,255,0.55)',
                                fontWeight: active ? '600' : '400',
                                fontSize: '14px',
                                boxShadow: active ? '0 4px 15px rgba(99,102,241,0.4)' : 'none',
                            }}>
                                <span style={{ flexShrink: 0 }}>{item.icon}</span>
                                {sidebarOpen && <span>{item.name}</span>}
                            </Link>
                        );
                    })}
                </nav>

                {/* Collapse toggle */}
                <div style={{ padding: '16px 12px', borderTop: '1px solid rgba(255,255,255,0.08)' }}>
                    <button onClick={() => setSidebarOpen(!sidebarOpen)} style={{
                        display: 'flex', alignItems: 'center', gap: '10px',
                        background: 'rgba(255,255,255,0.06)', border: 'none', borderRadius: '10px',
                        color: 'rgba(255,255,255,0.5)', cursor: 'pointer', padding: '10px 12px', width: '100%',
                        fontSize: '13px', fontWeight: '500', transition: 'all 0.2s',
                    }}>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ width: '16px', height: '16px', flexShrink: 0, transform: sidebarOpen ? 'rotate(0deg)' : 'rotate(180deg)', transition: 'transform 0.3s' }}>
                            <path d="M15 18l-6-6 6-6"/>
                        </svg>
                        {sidebarOpen && 'Collapse'}
                    </button>
                </div>
            </aside>

            {/* Main */}
            <div style={{ marginLeft: sidebarOpen ? '260px' : '72px', flex: 1, display: 'flex', flexDirection: 'column', transition: 'margin-left 0.3s ease', minHeight: '100vh' }}>
                {/* Header */}
                <header style={{
                    height: '64px', background: 'white', display: 'flex', alignItems: 'center',
                    justifyContent: 'space-between', padding: '0 28px',
                    boxShadow: '0 1px 0 rgba(0,0,0,0.06)', position: 'sticky', top: 0, zIndex: 40,
                }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '16px' }}>
                        <h2 style={{ fontSize: '14px', fontWeight: '500', color: '#6b7280', margin: 0 }}>
                            {navItems.find(n => n.path === location.pathname)?.name || 'Page'}
                        </h2>
                    </div>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '16px', position: 'relative' }} ref={dropdownRef}>
                        <button onClick={() => setDropdownOpen(!dropdownOpen)} style={{
                            display: 'flex', alignItems: 'center', gap: '10px',
                            background: '#f9fafb', border: '1px solid #e5e7eb', borderRadius: '10px',
                            cursor: 'pointer', padding: '8px 14px',
                        }}>
                            <div style={{
                                width: '28px', height: '28px', borderRadius: '50%',
                                background: 'linear-gradient(135deg, #6366f1, #8b5cf6)',
                                display: 'flex', alignItems: 'center', justifyContent: 'center',
                                color: 'white', fontSize: '12px', fontWeight: '700',
                            }}>{(user.name || 'A')[0].toUpperCase()}</div>
                            <span style={{ fontSize: '13px', fontWeight: '600', color: '#374151' }}>{user.name || 'Admin'}</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ width: '14px', color: '#9ca3af' }}>
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </button>
                        {dropdownOpen && (
                            <div style={{
                                position: 'absolute', top: '50px', right: 0, background: 'white',
                                border: '1px solid #e5e7eb', borderRadius: '12px', padding: '8px',
                                boxShadow: '0 10px 30px rgba(0,0,0,0.1)', minWidth: '160px', zIndex: 100,
                            }}>
                                <button onClick={handleLogout}
                                    onMouseEnter={e => e.currentTarget.style.background = '#fef2f2'}
                                    onMouseLeave={e => e.currentTarget.style.background = 'none'}
                                    style={{
                                        width: '100%', textAlign: 'left', background: 'none', border: 'none',
                                        padding: '10px 14px', borderRadius: '8px', cursor: 'pointer',
                                        fontSize: '13px', fontWeight: '500', color: '#ef4444',
                                        display: 'flex', alignItems: 'center', gap: '8px', transition: 'background 0.15s',
                                    }}>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ width: '15px' }}>
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                    Sign out
                                </button>
                            </div>
                        )}
                    </div>
                </header>

                {/* Page */}
                <main style={{ flex: 1, padding: '28px', overflow: 'auto' }}>
                    {children}
                </main>
            </div>
        </div>
    );
}
