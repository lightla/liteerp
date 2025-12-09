import React, { useEffect } from 'react';
import AuthLayout from '../layouts/AuthLayout';
import { useNavigate } from 'react-router-dom';
export default function Logout() {
    const navigate = useNavigate();
    localStorage.removeItem('business');
    localStorage.removeItem('token');
    useEffect(() => {
        navigate('/login')
    },[])
    return <AuthLayout>
        <div className='auth-verify-box text-center'>
            <h1 className='theme-title'>Logout account</h1>
            <p className='theme-title'>Please waiting for processing ....</p>
        </div>
    </AuthLayout>
}