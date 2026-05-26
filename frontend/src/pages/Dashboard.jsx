import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import api from '../lib/axios';

const StatCard = ({ title, value, subtitle, color, icon, href }) => {
    const inner = (
        <div style={{
            background: 'white', borderRadius: '16px', padding: '22px 24px',
            boxShadow: '0 1px 4px rgba(0,0,0,0.07)', display: 'flex', alignItems: 'center', gap: '18px',
            border: '1px solid #f1f3f9', transition: 'box-shadow 0.2s, transform 0.2s',
            cursor: href ? 'pointer' : 'default',
        }}
            onMouseEnter={e => {
                e.currentTarget.style.boxShadow = '0 8px 24px rgba(0,0,0,0.12)';
                if (href) e.currentTarget.style.transform = 'translateY(-2px)';
            }}
            onMouseLeave={e => {
                e.currentTarget.style.boxShadow = '0 1px 4px rgba(0,0,0,0.07)';
                e.currentTarget.style.transform = 'translateY(0)';
            }}
        >
            <div style={{
                width: '52px', height: '52px', borderRadius: '14px', flexShrink: 0,
                background: `linear-gradient(135deg, ${color}22, ${color}44)`,
                display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '24px',
            }}>{icon}</div>
            <div style={{ flex: 1, minWidth: 0 }}>
                <p style={{ margin: 0, fontSize: '12px', fontWeight: '600', color: '#9ca3af', textTransform: 'uppercase', letterSpacing: '0.5px' }}>{title}</p>
                <p style={{ margin: '4px 0 0', fontSize: '28px', fontWeight: '800', color: '#111827', lineHeight: 1 }}>{value}</p>
                {subtitle && <p style={{ margin: '3px 0 0', fontSize: '11px', color: '#9ca3af' }}>{subtitle}</p>}
            </div>
            <div style={{
                width: '36px', height: '36px', borderRadius: '50%', flexShrink: 0,
                background: color + '15', display: 'flex', alignItems: 'center', justifyContent: 'center',
            }}>
                <svg viewBox="0 0 24 24" fill="none" stroke={color} strokeWidth="2.5" style={{ width: '14px' }}>
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    );
    return href
        ? <Link to={href} style={{ textDecoration: 'none', display: 'block' }}>{inner}</Link>
        : inner;
};

export default function Dashboard() {
    const [data, setData] = useState(null);
    const [error, setError] = useState(null);

    useEffect(() => {
        api.get('/dashboard/stats')
            .then(r => setData(r.data.data))
            .catch(err => {
                console.error(err);
                setError(err.response?.data?.message || 'Failed to load dashboard. Make sure the backend is running.');
            });
    }, []);

    if (error) return (
        <div style={{ textAlign: 'center', padding: '60px' }}>
            <div style={{ background: '#fef2f2', border: '1px solid #fecaca', borderRadius: '12px', padding: '24px', display: 'inline-block' }}>
                <p style={{ margin: 0, fontSize: '15px', fontWeight: '600', color: '#dc2626' }}>⚠️ {error}</p>
            </div>
        </div>
    );

    if (!data) return (
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', height: '60vh', flexDirection: 'column', gap: '16px', color: '#9ca3af' }}>
            <div style={{ width: '40px', height: '40px', border: '3px solid #e5e7eb', borderTopColor: '#6366f1', borderRadius: '50%', animation: 'spin 0.8s linear infinite' }} />
            <p style={{ margin: 0, fontSize: '14px' }}>Loading dashboard...</p>
        </div>
    );

    const s = data.stats;
    const now = new Date();

    const statCards = [
        { title: 'Total Students', value: s.total_students, color: '#6366f1', icon: '🎓', subtitle: 'All registered', href: '/students' },
        { title: 'Active', value: s.active_students, color: '#10b981', icon: '📗', subtitle: 'Currently enrolled', href: '/students?status=active' },
        { title: 'Inactive', value: s.inactive_students, color: '#f59e0b', icon: '📙', subtitle: 'On hold', href: '/students?status=inactive' },
        { title: 'Graduated', value: s.graduated_students, color: '#3b82f6', icon: '🏆', subtitle: 'Completed', href: '/students?status=graduated' },
        { title: 'New This Month', value: s.new_this_month, color: '#8b5cf6', icon: '✨', subtitle: now.toLocaleString('default', { month: 'long', year: 'numeric' }), href: '/students' },
    ];

    const activeRate = s.total_students > 0 ? Math.round((s.active_students / s.total_students) * 100) : 0;

    return (
        <div style={{ display: 'flex', flexDirection: 'column', gap: '24px' }}>
            {/* Top Banner */}
            <div style={{
                background: 'linear-gradient(135deg, #1e1b4b 0%, #3730a3 50%, #4f46e5 100%)',
                borderRadius: '20px', padding: '28px 36px', color: 'white',
                display: 'flex', justifyContent: 'space-between', alignItems: 'center',
                boxShadow: '0 8px 32px rgba(79,70,229,0.35)', position: 'relative', overflow: 'hidden',
            }}>
                {/* decorative circles */}
                {[['top', '-50px', 'right', '-30px', '220px'], ['bottom', '-70px', 'right', '60px', '180px'], ['top', '20px', 'right', '200px', '80px']].map(([vside, vval, hside, hval, size], i) => (
                    <div key={i} style={{ position: 'absolute', [vside]: vval, [hside]: hval, width: size, height: size, borderRadius: '50%', background: 'rgba(255,255,255,0.05)' }} />
                ))}
                <div style={{ zIndex: 1 }}>
                    <p style={{ margin: '0 0 4px', fontSize: '12px', fontWeight: '600', opacity: 0.65, letterSpacing: '1px', textTransform: 'uppercase' }}>
                        {now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
                    </p>
                    <h1 style={{ margin: '0 0 8px', fontSize: '24px', fontWeight: '800', letterSpacing: '-0.5px' }}>
                        Welcome to Student Management
                    </h1>
                    <p style={{ margin: 0, opacity: 0.7, fontSize: '13px' }}>
                        You have <strong>{s.total_students}</strong> students registered. {s.new_this_month > 0 && `${s.new_this_month} joined this month!`}
                    </p>
                </div>
                <div style={{ display: 'flex', gap: '10px', zIndex: 1 }}>
                    <Link to="/students" style={{
                        background: 'rgba(255,255,255,0.12)', color: 'white', fontWeight: '600', fontSize: '13px',
                        padding: '10px 20px', borderRadius: '10px', textDecoration: 'none',
                        border: '1px solid rgba(255,255,255,0.2)',
                    }}>View Students</Link>
                    <Link to="/students/new" style={{
                        background: 'white', color: '#4f46e5', fontWeight: '700', fontSize: '13px',
                        padding: '10px 20px', borderRadius: '10px', textDecoration: 'none',
                        boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
                    }}>+ Add Student</Link>
                </div>
            </div>

            {/* Stat Cards */}
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '14px' }}>
                {statCards.map(card => <StatCard key={card.title} {...card} />)}
            </div>

            {/* Bottom section */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px' }}>
                {/* Active Rate */}
                <div style={{ background: 'white', borderRadius: '16px', padding: '24px', boxShadow: '0 1px 4px rgba(0,0,0,0.07)', border: '1px solid #f1f3f9' }}>
                    <h3 style={{ margin: '0 0 20px', fontSize: '15px', fontWeight: '700', color: '#111827' }}>Enrollment Rate</h3>
                    <div style={{ display: 'flex', alignItems: 'flex-end', gap: '12px', marginBottom: '12px' }}>
                        <span style={{ fontSize: '42px', fontWeight: '800', color: '#10b981', lineHeight: 1 }}>{activeRate}%</span>
                        <span style={{ fontSize: '13px', color: '#6b7280', paddingBottom: '6px' }}>of students active</span>
                    </div>
                    <div style={{ background: '#f3f4f6', borderRadius: '999px', height: '8px', overflow: 'hidden' }}>
                        <div style={{ width: `${activeRate}%`, height: '100%', background: 'linear-gradient(90deg, #10b981, #34d399)', borderRadius: '999px', transition: 'width 1s ease' }} />
                    </div>
                    <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: '12px', fontSize: '12px', color: '#9ca3af' }}>
                        <span>0%</span><span>100%</span>
                    </div>
                </div>

                {/* Status Breakdown */}
                <div style={{ background: 'white', borderRadius: '16px', padding: '24px', boxShadow: '0 1px 4px rgba(0,0,0,0.07)', border: '1px solid #f1f3f9' }}>
                    <h3 style={{ margin: '0 0 20px', fontSize: '15px', fontWeight: '700', color: '#111827' }}>Status Breakdown</h3>
                    {[
                        { label: 'Active', count: s.active_students, color: '#10b981', bg: '#d1fae5', status: 'active' },
                        { label: 'Inactive', count: s.inactive_students, color: '#f59e0b', bg: '#fef3c7', status: 'inactive' },
                        { label: 'Graduated', count: s.graduated_students, color: '#3b82f6', bg: '#dbeafe', status: 'graduated' },
                    ].map(({ label, count, color, bg, status }) => (
                        <Link key={label} to={`/students?status=${status}`} style={{ textDecoration: 'none', display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '10px 0', borderBottom: '1px solid #f9fafb', cursor: 'pointer', transition: 'background 0.15s', borderRadius: '6px', margin: '0 -6px', padding: '10px 6px' }}
                            onMouseEnter={e => e.currentTarget.style.background = '#f9fafb'}
                            onMouseLeave={e => e.currentTarget.style.background = 'transparent'}
                        >
                            <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                <div style={{ width: '8px', height: '8px', borderRadius: '50%', background: color }} />
                                <span style={{ fontSize: '13px', fontWeight: '500', color: '#374151' }}>{label}</span>
                            </div>
                            <span style={{ background: bg, color, fontSize: '12px', fontWeight: '700', padding: '3px 10px', borderRadius: '999px' }}>
                                {count}
                            </span>
                        </Link>
                    ))}
                </div>
            </div>
        </div>
    );
}
