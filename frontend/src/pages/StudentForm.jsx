import { useState, useEffect } from 'react';
import { useNavigate, useParams, Link } from 'react-router-dom';
import api from '../lib/axios';

export default function StudentForm() {
    const { id } = useParams();
    const navigate = useNavigate();
    const isEditing = Boolean(id);

    const [formData, setFormData] = useState({
        name: '',
        email: '',
        phone: '',
        grade: '',
        address: '',
        date_of_birth: '',
        guardian_name: '',
        guardian_phone: '',
        status: 'active'
    });
    
    const [loading, setLoading] = useState(isEditing);
    const [errors, setErrors] = useState({});

    useEffect(() => {
        if (isEditing) {
            fetchStudent();
        }
    }, [id]);

    const fetchStudent = async () => {
        try {
            const response = await api.get(`/students/${id}`);
            const student = response.data.data;
            if (student.date_of_birth) {
                student.date_of_birth = student.date_of_birth.split('T')[0];
            }
            setFormData(student);
        } catch (error) {
            console.error("Error fetching student", error);
            navigate('/students');
        } finally {
            setLoading(false);
        }
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});
        
        try {
            if (isEditing) {
                await api.put(`/students/${id}`, formData);
            } else {
                await api.post('/students', formData);
            }
            navigate('/students');
        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors || {});
            } else {
                console.error("Error saving student", error);
            }
        }
    };

    const handleUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const uploadData = new FormData();
        uploadData.append('document', file);
        uploadData.append('type', 'Other'); // Default type

        try {
            await api.post(`/students/${id}/documents`, uploadData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            fetchStudent(); // Refresh list
        } catch (error) {
            console.error("Error uploading document", error);
        }
    };

    const deleteDocument = async (docId) => {
        if (!confirm('Delete this document?')) return;
        try {
            await api.delete(`/documents/${docId}`);
            fetchStudent();
        } catch (error) {
            console.error("Error deleting document", error);
        }
    };

    if (loading) return <div className="p-8 text-center">Loading...</div>;

    return (
        <div className="min-h-screen bg-gray-50">
            <nav className="bg-white shadow">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex">
                            <div className="flex-shrink-0 flex items-center">
                                <h1 className="text-xl font-bold text-blue-600">SMS</h1>
                            </div>
                            <div className="hidden sm:ml-6 sm:flex sm:space-x-8">
                                <Link to="/" className="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Dashboard
                                </Link>
                                <Link to="/students" className="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Students
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div className="px-4 py-6 sm:px-0">
                    <div className="flex items-center justify-between mb-6">
                        <h2 className="text-2xl font-semibold text-gray-900">
                            {isEditing ? 'Edit Student' : 'Add New Student'}
                        </h2>
                        <Link to="/students" className="text-gray-600 hover:text-gray-900">
                            &larr; Back to List
                        </Link>
                    </div>

                    <div className="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                        <form onSubmit={handleSubmit} className="space-y-6">
                            <div className="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" value={formData.name} onChange={handleChange} required className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                    {errors.name && <p className="mt-2 text-sm text-red-600">{errors.name[0]}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" value={formData.email} onChange={handleChange} required className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                    {errors.email && <p className="mt-2 text-sm text-red-600">{errors.email[0]}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" name="phone" value={formData.phone} onChange={handleChange} className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                    {errors.phone && <p className="mt-2 text-sm text-red-600">{errors.phone[0]}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <input type="date" name="date_of_birth" value={formData.date_of_birth} onChange={handleChange} className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                    {errors.date_of_birth && <p className="mt-2 text-sm text-red-600">{errors.date_of_birth[0]}</p>}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Grade</label>
                                    <input type="text" name="grade" value={formData.grade} onChange={handleChange} className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" value={formData.status} onChange={handleChange} className="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="graduated">Graduated</option>
                                    </select>
                                </div>

                                <div className="sm:col-span-2">
                                    <label className="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea name="address" value={formData.address} onChange={handleChange} rows="3" className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Guardian Name</label>
                                    <input type="text" name="guardian_name" value={formData.guardian_name} onChange={handleChange} className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Guardian Phone</label>
                                    <input type="text" name="guardian_phone" value={formData.guardian_phone} onChange={handleChange} className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                </div>
                            </div>

                            <div className="flex justify-end mt-6">
                                <button type="submit" className="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {isEditing ? 'Save Changes' : 'Add Student'}
                                </button>
                            </div>
                        </form>
                    </div>

                    {isEditing && (
                        <div className="mt-8 bg-white shadow overflow-hidden sm:rounded-lg p-6">
                            <h3 className="text-lg font-medium text-gray-900 mb-4">Documents</h3>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-gray-700 mb-2">Upload New Document</label>
                                <input type="file" onChange={handleUpload} className="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            </div>
                            <ul className="divide-y divide-gray-200">
                                {formData.documents?.map(doc => (
                                    <li key={doc.id} className="py-3 flex justify-between items-center">
                                        <div className="flex flex-col">
                                            <span className="text-sm font-medium text-gray-900">{doc.file_name}</span>
                                            <span className="text-xs text-gray-500">{doc.document_type} • {new Date(doc.created_at).toLocaleDateString()}</span>
                                        </div>
                                        <div className="flex space-x-3">
                                            <a href={`http://127.0.0.1:8000/api/documents/${doc.id}/download`} target="_blank" rel="noopener noreferrer" className="text-blue-600 hover:text-blue-800 text-sm">Download</a>
                                            <button onClick={() => deleteDocument(doc.id)} className="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                        </div>
                                    </li>
                                ))}
                                {(!formData.documents || formData.documents.length === 0) && (
                                    <li className="py-3 text-sm text-gray-500">No documents uploaded yet.</li>
                                )}
                            </ul>
                        </div>
                    )}
                </div>
            </main>
        </div>
    );
}
