import { useState, useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import api from '../lib/axios';

const StatusPill = ({ status }) => {
    const colors = {
        active: { bg: '#d1fae5', text: '#065f46', dot: '#10b981' },
        inactive: { bg: '#fee2e2', text: '#991b1b', dot: '#ef4444' },
        graduated: { bg: '#dbeafe', text: '#1e40af', dot: '#3b82f6' },
    };
    const c = colors[status] || { bg: '#f3f4f6', text: '#374151', dot: '#9ca3af' };
    return (
        <span style={{ display: 'inline-flex', alignItems: 'center', gap: '6px', padding: '4px 12px', borderRadius: '999px', background: c.bg, color: c.text, fontSize: '12px', fontWeight: '600' }}>
            <span style={{ width: '6px', height: '6px', borderRadius: '50%', background: c.dot, flexShrink: 0 }} />
            {status ? status.charAt(0).toUpperCase() + status.slice(1) : 'Unknown'}
        </span>
    );
};

export default function Students() {
    const navigate = useNavigate();
    const [students, setStudents] = useState([]);
    const [loading, setLoading] = useState(true);
    const [search, setSearch] = useState('');
    const [status, setStatus] = useState('all');
    const [perPage, setPerPage] = useState(10);
    const [selectedIds, setSelectedIds] = useState([]);
    const [bulkAction, setBulkAction] = useState('');
    const [pagination, setPagination] = useState(null);
    const [sortBy, setSortBy] = useState('name');
    const [sortDir, setSortDir] = useState('asc');

    useEffect(() => {
        fetchStudents();
    }, [status, perPage, sortBy, sortDir]);

    const fetchStudents = async () => {
        setLoading(true);
        try {
            const response = await api.get('/students', {
                params: { search, status, per_page: perPage, sort: sortBy, direction: sortDir }
            });
            setStudents(response.data.data.data || []);
            setPagination(response.data.data);
        } catch (error) {
            console.error('Error fetching students', error);
        } finally {
            setLoading(false);
        }
    };

    const handleSearch = (e) => {
        e.preventDefault();
        fetchStudents();
    };

    const clearFilters = () => {
        setSearch(''); setStatus('all'); setPerPage(10); setSortBy('name'); setSortDir('asc');
        setTimeout(fetchStudents, 0);
    };

    const handleSort = (col) => {
        if (sortBy === col) setSortDir(d => d === 'asc' ? 'desc' : 'asc');
        else { setSortBy(col); setSortDir('asc'); }
    };

    const handleDelete = async (id) => {
        if (!confirm('Delete this student?')) return;
        await api.delete(`/students/${id}`);
        fetchStudents();
    };

    const handleBulkApply = async () => {
        if (!selectedIds.length || !bulkAction) return;
        if (bulkAction === 'delete') {
            if (!confirm(`Delete ${selectedIds.length} students?`)) return;
            await api.post('/students/bulk-delete', { student_ids: selectedIds });
        } else {
            await api.post('/students/bulk-status', { student_ids: selectedIds, status: bulkAction });
        }
        setSelectedIds([]); fetchStudents();
    };

    const toggleAll = () => setSelectedIds(selectedIds.length === students.length ? [] : students.map(s => s.id));
    const toggleOne = (id) => setSelectedIds(prev => prev.includes(id) ? prev.filter(i => i !== id) : [...prev, id]);

    const SortIcon = ({ col }) => (
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" style={{ width: '12px', marginLeft: '4px', color: sortBy === col ? '#6366f1' : '#d1d5db' }}>
            {sortBy === col && sortDir === 'asc' ? <path d="M5 15l7-7 7 7" /> : <path d="M19 9l-7 7-7-7" />}
        </svg>
    );

    const headerStyle = (col) => ({
        padding: '12px 16px', textAlign: 'left', fontSize: '11px', fontWeight: '700',
        color: '#6b7280', textTransform: 'uppercase', letterSpacing: '0.6px',
        cursor: 'pointer', userSelect: 'none', whiteSpace: 'nowrap',
        color: sortBy === col ? '#6366f1' : '#6b7280',
    });

    return (
        <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
            {/* Page Header */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', flexWrap: 'wrap', gap: '12px' }}>

                <div>
                    <h1 style={{ margin: 0, fontSize: '22px', fontWeight: '800', color: '#1a1d2e' }}>Students</h1>
                    <p style={{ margin: '4px 0 0', fontSize: '13px', color: '#9ca3af' }}>
                        {pagination ? `${pagination.total || 0} total students` : 'Loading...'}
                    </p>
                </div>
                <div style={{ display: 'flex', gap: '10px', flexWrap: 'wrap' }}>
                    <button onClick={() => window.open('http://127.0.0.1:8000/api/students/export')} style={{
                        display: 'flex', alignItems: 'center', gap: '6px',
                        background: 'white', border: '1px solid #e5e7eb', borderRadius: '10px',
                        padding: '9px 16px', fontSize: '13px', fontWeight: '600', color: '#374151',
                        cursor: 'pointer', boxShadow: '0 1px 2px rgba(0,0,0,0.05)',
                    }}>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ width: '15px' }}>
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" /><polyline points="7 10 12 15 17 10" /><line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Export CSV
                    </button>
                    <Link to="/students/new" style={{
                        display: 'flex', alignItems: 'center', gap: '6px',
                        background: 'linear-gradient(135deg, #6366f1, #8b5cf6)', color: 'white',
                        padding: '9px 18px', borderRadius: '10px', textDecoration: 'none',
                        fontSize: '13px', fontWeight: '700', boxShadow: '0 4px 12px rgba(99,102,241,0.35)',
                    }}>
                        + Add Student
                    </Link>
                </div>
            </div>


            {/* Filters */}
            <div style={{ background: 'white', borderRadius: '16px', padding: '16px 20px', boxShadow: '0 1px 3px rgba(0,0,0,0.06)' }}>
                <form onSubmit={handleSearch} style={{ display: 'flex', gap: '12px', flexWrap: 'wrap', alignItems: 'center' }}>
                    <div style={{ flex: '1 1 240px', position: 'relative' }}>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ width: '15px', position: 'absolute', left: '12px', top: '50%', transform: 'translateY(-50%)', color: '#9ca3af' }}>
                            <circle cx="11" cy="11" r="8" /><path d="m21 21-4.35-4.35" />
                        </svg>
                        <input
                            type="text" placeholder="Search by name, email, phone, grade..."
                            value={search} onChange={e => setSearch(e.target.value)}
                            style={{ width: '100%', paddingLeft: '36px', paddingRight: '12px', paddingTop: '9px', paddingBottom: '9px', border: '1px solid #e5e7eb', borderRadius: '10px', fontSize: '13px', outline: 'none', background: '#f9fafb' }}
                        />
                    </div>
                    <select value={status} onChange={e => setStatus(e.target.value)} style={{ border: '1px solid #e5e7eb', borderRadius: '10px', padding: '9px 14px', fontSize: '13px', background: '#f9fafb', cursor: 'pointer', outline: 'none' }}>
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="graduated">Graduated</option>
                    </select>
                    <select value={perPage} onChange={e => setPerPage(+e.target.value)} style={{ border: '1px solid #e5e7eb', borderRadius: '10px', padding: '9px 14px', fontSize: '13px', background: '#f9fafb', cursor: 'pointer', outline: 'none' }}>
                        <option value={10}>10 / page</option>
                        <option value={25}>25 / page</option>
                        <option value={50}>50 / page</option>
                    </select>
                    <button type="submit" style={{ background: 'linear-gradient(135deg, #6366f1, #8b5cf6)', color: 'white', border: 'none', borderRadius: '10px', padding: '9px 20px', fontSize: '13px', fontWeight: '600', cursor: 'pointer' }}>
                        Filter
                    </button>
                    <button type="button" onClick={clearFilters} style={{ background: 'none', border: '1px solid #e5e7eb', borderRadius: '10px', padding: '9px 16px', fontSize: '13px', color: '#6b7280', cursor: 'pointer' }}>
                        Clear
                    </button>
                </form>
            </div>

            {/* Bulk Actions */}
            {selectedIds.length > 0 && (
                <div style={{ background: '#eff6ff', border: '1px solid #bfdbfe', borderRadius: '12px', padding: '12px 20px', display: 'flex', alignItems: 'center', gap: '16px', flexWrap: 'wrap' }}>
                    <span style={{ fontSize: '13px', fontWeight: '600', color: '#1d4ed8' }}>
                        {selectedIds.length} selected
                    </span>
                    <select value={bulkAction} onChange={e => setBulkAction(e.target.value)} style={{ border: '1px solid #bfdbfe', borderRadius: '8px', padding: '6px 12px', fontSize: '13px', background: 'white', cursor: 'pointer' }}>
                        <option value="">Choose Action</option>
                        <option value="active">Set Active</option>
                        <option value="inactive">Set Inactive</option>
                        <option value="graduated">Set Graduated</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button onClick={handleBulkApply} style={{ background: '#ef4444', color: 'white', border: 'none', borderRadius: '8px', padding: '7px 16px', fontSize: '13px', fontWeight: '600', cursor: 'pointer' }}>
                        Apply
                    </button>
                    <button onClick={() => setSelectedIds([])} style={{ background: 'none', border: 'none', color: '#6b7280', fontSize: '13px', cursor: 'pointer' }}>
                        Deselect all
                    </button>
                </div>
            )}

            {/* Table */}
            <div style={{ background: 'white', borderRadius: '16px', boxShadow: '0 1px 3px rgba(0,0,0,0.06)', overflow: 'hidden' }}>
                {/* Table meta */}
                <div style={{ padding: '14px 20px', borderBottom: '1px solid #f3f4f6', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                    <label style={{ display: 'flex', alignItems: 'center', gap: '8px', cursor: 'pointer', fontSize: '13px', fontWeight: '600', color: '#374151' }}>
                        <input type="checkbox"
                            checked={selectedIds.length === students.length && students.length > 0}
                            onChange={toggleAll}
                            style={{ width: '15px', height: '15px', accentColor: '#6366f1', cursor: 'pointer' }}
                        />
                        Select All
                    </label>
                    <span style={{ fontSize: '12px', color: '#9ca3af' }}>
                        {pagination ? `${pagination.from || 0}–${pagination.to || 0} of ${pagination.total || 0}` : ''}
                    </span>
                </div>

                <div style={{ overflowX: 'auto' }}>
                    <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                        <thead>
                            <tr style={{ background: '#f9fafb' }}>
                                <th style={{ width: '48px', padding: '12px 16px' }} />
                                {[['Name', 'name'], ['Email', 'email'], ['Phone', null], ['Grade', 'grade'], ['Status', 'status'], ['Joined', 'created_at']].map(([label, col]) => (
                                    <th key={label} style={headerStyle(col)} onClick={() => col && handleSort(col)}>
                                        <span style={{ display: 'inline-flex', alignItems: 'center' }}>
                                            {label}{col && <SortIcon col={col} />}
                                        </span>
                                    </th>
                                ))}
                                <th style={{ padding: '12px 16px', textAlign: 'right', fontSize: '11px', fontWeight: '700', color: '#6b7280', textTransform: 'uppercase' }}>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {loading ? (
                                <tr><td colSpan="8" style={{ padding: '60px', textAlign: 'center', color: '#9ca3af' }}>Loading...</td></tr>
                            ) : students.length === 0 ? (
                                <tr><td colSpan="8" style={{ padding: '60px', textAlign: 'center', color: '#9ca3af' }}>
                                    No students found. <Link to="/students/new" style={{ color: '#6366f1', fontWeight: '600' }}>Add one?</Link>
                                </td></tr>
                            ) : students.map((student, i) => (
                                <tr key={student.id}
                                    style={{ borderTop: '1px solid #f3f4f6', transition: 'background 0.15s', background: selectedIds.includes(student.id) ? '#f5f3ff' : 'transparent' }}
                                    onMouseEnter={e => { if (!selectedIds.includes(student.id)) e.currentTarget.style.background = '#fafafa'; }}
                                    onMouseLeave={e => { e.currentTarget.style.background = selectedIds.includes(student.id) ? '#f5f3ff' : 'transparent'; }}
                                >
                                    <td style={{ padding: '14px 16px', width: '48px' }}>
                                        <input type="checkbox" checked={selectedIds.includes(student.id)} onChange={() => toggleOne(student.id)}
                                            style={{ width: '15px', height: '15px', accentColor: '#6366f1', cursor: 'pointer' }} />
                                    </td>
                                    <td style={{ padding: '14px 16px' }}>
                                        <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                            {student.profile_picture_url ? (
                                                <img src={student.profile_picture_url} alt={student.name} style={{ width: '36px', height: '36px', borderRadius: '50%', objectFit: 'cover', flexShrink: 0 }} />
                                            ) : (
                                                <div style={{
                                                    width: '36px', height: '36px', borderRadius: '50%', flexShrink: 0,
                                                    background: `hsl(${(i * 47 + 200) % 360}, 65%, 55%)`,
                                                    display: 'flex', alignItems: 'center', justifyContent: 'center',
                                                    color: 'white', fontSize: '13px', fontWeight: '700',
                                                }}>{student.name?.[0]?.toUpperCase()}</div>
                                            )}
                                            <span style={{ fontSize: '14px', fontWeight: '600', color: '#1a1d2e' }}>{student.name}</span>
                                        </div>
                                    </td>
                                    <td style={{ padding: '14px 16px', fontSize: '13px', color: '#6b7280' }}>{student.email}</td>
                                    <td style={{ padding: '14px 16px', fontSize: '13px', color: '#6b7280' }}>{student.phone || '—'}</td>
                                    <td style={{ padding: '14px 16px', fontSize: '13px', color: '#6b7280' }}>{student.grade || '—'}</td>
                                    <td style={{ padding: '14px 16px' }}><StatusPill status={student.status} /></td>
                                    <td style={{ padding: '14px 16px', fontSize: '12px', color: '#9ca3af', whiteSpace: 'nowrap' }}>
                                        {new Date(student.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                                    </td>
                                    <td style={{ padding: '14px 16px', textAlign: 'right' }}>
                                        <div style={{ display: 'flex', gap: '6px', justifyContent: 'flex-end' }}>
                                            <button onClick={() => navigate(`/students/${student.id}`)} style={{
                                                background: '#f0fdf4', color: '#16a34a', border: 'none', borderRadius: '8px',
                                                padding: '6px 14px', fontSize: '12px', fontWeight: '600', cursor: 'pointer',
                                            }}>View</button>
                                            <button onClick={() => navigate(`/students/${student.id}/edit`)} style={{
                                                background: '#f0f1ff', color: '#6366f1', border: 'none', borderRadius: '8px',
                                                padding: '6px 14px', fontSize: '12px', fontWeight: '600', cursor: 'pointer',
                                            }}>Edit</button>
                                            <button onClick={() => handleDelete(student.id)} style={{
                                                background: '#fff0f0', color: '#ef4444', border: 'none', borderRadius: '8px',
                                                padding: '6px 14px', fontSize: '12px', fontWeight: '600', cursor: 'pointer',
                                            }}>Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {/* Pagination */}
                {pagination && pagination.last_page > 1 && (
                    <div style={{ padding: '16px 20px', borderTop: '1px solid #f3f4f6', display: 'flex', justifyContent: 'center', gap: '6px' }}>
                        {Array.from({ length: pagination.last_page }, (_, i) => i + 1).map(page => (
                            <button key={page} style={{
                                width: '32px', height: '32px', borderRadius: '8px', border: 'none', cursor: 'pointer',
                                background: page === pagination.current_page ? 'linear-gradient(135deg, #6366f1, #8b5cf6)' : '#f9fafb',
                                color: page === pagination.current_page ? 'white' : '#374151',
                                fontSize: '13px', fontWeight: page === pagination.current_page ? '700' : '400',
                            }}>{page}</button>
                        ))}
                    </div>
                )}
            </div>
        </div>
    );
}
