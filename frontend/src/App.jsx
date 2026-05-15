import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import Login from './pages/Login';
import Register from './pages/Register';
import Dashboard from './pages/Dashboard';
import Students from './pages/Students';
import StudentForm from './pages/StudentForm';
import StudentView from './pages/StudentView';
import Layout from './components/Layout';

const PrivateRoute = ({ children }) => {
    const token = localStorage.getItem('token');
    return token ? <Layout>{children}</Layout> : <Navigate to="/login" />;
};

function App() {
    return (
        <Router>
            <Routes>
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="/" element={
                    <PrivateRoute>
                        <Dashboard />
                    </PrivateRoute>
                } />
                <Route path="/students" element={
                    <PrivateRoute>
                        <Students />
                    </PrivateRoute>
                } />
                <Route path="/students/new" element={
                    <PrivateRoute>
                        <StudentForm />
                    </PrivateRoute>
                } />
                <Route path="/students/:id" element={
                    <PrivateRoute>
                        <StudentView />
                    </PrivateRoute>
                } />
                <Route path="/students/:id/edit" element={
                    <PrivateRoute>
                        <StudentForm />
                    </PrivateRoute>
                } />
            </Routes>
        </Router>
    );
}

export default App;
