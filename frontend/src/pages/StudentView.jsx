import { useState, useEffect } from 'react';
import { Link, useParams, useNavigate } from 'react-router-dom';
import api from '../lib/axios';

const InfoRow = ({ label, value }) => (
    <div style={{ display: 'flex', borderBottom: '1px solid #f3f4f6', padding: '14px 0' }}>
        <span style={{ width: '180px', flexShrink: 0, fontSize: '12px', fontWeight: '600', color: '#9ca3af', textTransform: 'uppercase', letterSpacing: '0.5px', paddingTop: '2px' }}>{label}</span>
        <span style={{ fontSize: '14px', fontWeight: '500', color: '#111827' }}>{value || <span style={{ color: '#d1d5db', fontStyle: 'italic' }}>Not provided</span>}</span>
    </div>
);

const StatusPill = ({ status }) => {
    const map = {
        active: { bg: '#d1fae5', text: '#065f46', dot: '#10b981' },
        inactive: { bg: '#fee2e2', text: '#991b1b', dot: '#ef4444' },
        graduated: { bg: '#dbeafe', text: '#1e40af', dot: '#3b82f6' },
    };
    const c = map[status] || { bg: '#f3f4f6', text: '#374151', dot: '#9ca3af' };
    return (
        <span style={{ display: 'inline-flex', alignItems: 'center', gap: '6px', padding: '6px 14px', borderRadius: '999px', background: c.bg, color: c.text, fontSize: '13px', fontWeight: '700' }}>
            <span style={{ width: '8px', height: '8px', borderRadius: '50%', background: c.dot }} />
            {status?.charAt(0).toUpperCase() + status?.slice(1)}
        </span>
    );
};

export default function StudentView() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [student, setStudent] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        api.get(`/students/${id}`)
            .then(r => setStudent(r.data.data))
            .catch(err => setError('Student not found.'))
            .finally(() => setLoading(false));
    }, [id]);

    const handleDelete = async () => {
        if (!confirm(`Delete ${student.name}? This cannot be undone.`)) return;
        await api.delete(`/students/${id}`);
        navigate('/students');
    };

    if (loading) return (
        <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '60vh', flexDirection: 'column', gap: '16px', color: '#9ca3af' }}>
            <div style={{ width: '36px', height: '36px', border: '3px solid #e5e7eb', borderTopColor: '#6366f1', borderRadius: '50%', animation: 'spin 0.8s linear infinite' }} />
            <p style={{ margin: 0, fontSize: '14px' }}>Loading student...</p>
        </div>
    );

    if (error) return (
        <div style={{ textAlign: 'center', padding: '60px' }}>
            <p style={{ color: '#ef4444', fontWeight: '600' }}>⚠️ {error}</p>
            <Link to="/students" style={{ color: '#6366f1', fontWeight: '600', textDecoration: 'none', marginTop: '12px', display: 'inline-block' }}>← Back to Students</Link>
        </div>
    );

    const avatarColor = `hsl(${(student.name.charCodeAt(0) * 17) % 360}, 60%, 50%)`;
    const age = student.date_of_birth
        ? Math.floor((new Date() - new Date(student.date_of_birth)) / (365.25 * 24 * 3600 * 1000))
        : null;

    return (
        <div style={{ display: 'flex', flexDirection: 'column', gap: '20px', maxWidth: '900px' }}>
            {/* Breadcrumb */}
            <div style={{ display: 'flex', alignItems: 'center', gap: '8px', fontSize: '13px', color: '#9ca3af' }}>
                <Link to="/" style={{ color: '#9ca3af', textDecoration: 'none' }}>Dashboard</Link>
                <span>/</span>
                <Link to="/students" style={{ color: '#9ca3af', textDecoration: 'none' }}>Students</Link>
                <span>/</span>
                <span style={{ color: '#374151', fontWeight: '500' }}>{student.name}</span>
            </div>

            {/* Profile Header Card */}
            <div style={{
                background: 'white', borderRadius: '20px', padding: '32px',
                boxShadow: '0 1px 4px rgba(0,0,0,0.07)', border: '1px solid #f1f3f9',
                display: 'flex', alignItems: 'center', justifyContent: 'space-between', flexWrap: 'wrap', gap: '20px',
            }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
                    {/* Avatar */}
                    <div style={{
                        width: '80px', height: '80px', borderRadius: '50%', flexShrink: 0,
                        background: `linear-gradient(135deg, ${avatarColor}, ${avatarColor}bb)`,
                        display: 'flex', alignItems: 'center', justifyContent: 'center',
                        color: 'white', fontSize: '32px', fontWeight: '800',
                        boxShadow: `0 8px 24px ${avatarColor}55`,
                    }}>{student.name[0].toUpperCase()}</div>
                    <div>
                        <h1 style={{ margin: '0 0 6px', fontSize: '22px', fontWeight: '800', color: '#111827' }}>{student.name}</h1>
                        <p style={{ margin: '0 0 10px', fontSize: '14px', color: '#6b7280' }}>{student.email}</p>
                        <StatusPill status={student.status} />
                    </div>
                </div>
                <div style={{ display: 'flex', gap: '10px' }}>
                    <Link to={`/students/${id}/edit`} style={{
                        display: 'inline-flex', alignItems: 'center', gap: '6px',
                        background: 'linear-gradient(135deg, #6366f1, #8b5cf6)', color: 'white',
                        padding: '10px 20px', borderRadius: '10px', textDecoration: 'none',
                        fontSize: '13px', fontWeight: '700', boxShadow: '0 4px 12px rgba(99,102,241,0.3)',
                    }}>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ width: '14px' }}>
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit
                    </Link>
                    <button onClick={handleDelete} style={{
                        display: 'inline-flex', alignItems: 'center', gap: '6px',
                        background: '#fff0f0', color: '#ef4444', border: '1px solid #fecaca',
                        padding: '10px 20px', borderRadius: '10px', cursor: 'pointer',
                        fontSize: '13px', fontWeight: '700',
                    }}>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{ width: '14px' }}>
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                        Delete
                    </button>
                    <Link to="/students" style={{
                        display: 'inline-flex', alignItems: 'center', gap: '6px',
                        background: '#f9fafb', color: '#374151', border: '1px solid #e5e7eb',
                        padding: '10px 18px', borderRadius: '10px', textDecoration: 'none',
                        fontSize: '13px', fontWeight: '600',
                    }}>← Back</Link>
                </div>
            </div>

            {/* Details Cards */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px' }}>
                {/* Personal Information */}
                <div style={{ background: 'white', borderRadius: '16px', padding: '24px', boxShadow: '0 1px 4px rgba(0,0,0,0.07)', border: '1px solid #f1f3f9' }}>
                    <h2 style={{ margin: '0 0 4px', fontSize: '14px', fontWeight: '700', color: '#111827' }}>Personal Information</h2>
                    <p style={{ margin: '0 0 16px', fontSize: '12px', color: '#9ca3af' }}>Student's personal details</p>
                    <InfoRow label="Full Name" value={student.name} />
                    <InfoRow label="Email" value={student.email} />
                    <InfoRow label="Phone" value={student.phone} />
                    <InfoRow label="Date of Birth" value={student.date_of_birth
                        ? `${new Date(student.date_of_birth).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}${age ? ` (${age} years old)` : ''}`
                        : null} />
                    <InfoRow label="Address" value={student.address} />
                </div>

                {/* Academic Information */}
                <div style={{ background: 'white', borderRadius: '16px', padding: '24px', boxShadow: '0 1px 4px rgba(0,0,0,0.07)', border: '1px solid #f1f3f9' }}>
                    <h2 style={{ margin: '0 0 4px', fontSize: '14px', fontWeight: '700', color: '#111827' }}>Academic Information</h2>
                    <p style={{ margin: '0 0 16px', fontSize: '12px', color: '#9ca3af' }}>Enrollment and academic details</p>
                    <InfoRow label="Grade / Class" value={student.grade} />
                    <InfoRow label="Status" value={<StatusPill status={student.status} />} />
                    <InfoRow label="Enrolled On" value={new Date(student.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })} />
                    <InfoRow label="Last Updated" value={new Date(student.updated_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })} />
                </div>
            </div>

            {/* Guardian */}
            {(student.guardian_name || student.guardian_phone) && (
                <div style={{ background: 'white', borderRadius: '16px', padding: '24px', boxShadow: '0 1px 4px rgba(0,0,0,0.07)', border: '1px solid #f1f3f9' }}>
                    <h2 style={{ margin: '0 0 4px', fontSize: '14px', fontWeight: '700', color: '#111827' }}>Guardian Information</h2>
                    <p style={{ margin: '0 0 16px', fontSize: '12px', color: '#9ca3af' }}>Parent or guardian contact</p>
                    <InfoRow label="Guardian Name" value={student.guardian_name} />
                    <InfoRow label="Guardian Phone" value={student.guardian_phone} />
                </div>
            )}

            {/* Documents */}
            {student.documents && student.documents.length > 0 && (
                <div style={{ background: 'white', borderRadius: '16px', padding: '24px', boxShadow: '0 1px 4px rgba(0,0,0,0.07)', border: '1px solid #f1f3f9' }}>
                    <h2 style={{ margin: '0 0 16px', fontSize: '14px', fontWeight: '700', color: '#111827' }}>Documents ({student.documents.length})</h2>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '10px' }}>
                        {student.documents.map(doc => (
                            <div key={doc.id} style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', padding: '12px 16px', background: '#f9fafb', borderRadius: '10px', border: '1px solid #f3f4f6' }}>
                                <div style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                                    <div style={{ width: '36px', height: '36px', background: '#eff6ff', borderRadius: '8px', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '16px' }}>📄</div>
                                    <div>
                                        <p style={{ margin: 0, fontSize: '13px', fontWeight: '600', color: '#111827' }}>{doc.file_name}</p>
                                        <p style={{ margin: '2px 0 0', fontSize: '11px', color: '#9ca3af' }}>{doc.document_type} • {new Date(doc.created_at).toLocaleDateString()}</p>
                                    </div>
                                </div>
                                <a href={`http://127.0.0.1:8000/api/documents/${doc.id}/download`} target="_blank" rel="noopener noreferrer"
                                    style={{ color: '#6366f1', fontSize: '12px', fontWeight: '600', textDecoration: 'none' }}>
                                    Download
                                </a>
                            </div>
                        ))}
                    </div>
                </div>
            )}
        </div>
    );
}
