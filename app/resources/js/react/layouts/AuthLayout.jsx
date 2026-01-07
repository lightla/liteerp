import React from 'react';
import { useDispatch, useSelector } from "react-redux";
import LanguageSwitcher from '../components/LanguageSwitcher';
export default function AuthLayout(data = {
    children
}) {
    const theme = useSelector((state) => state.theme.mode);
    return <div className="auth-page-body" data-theme={theme}>
        <div>
            {/** Langauges */}
            <div>
                <div className="text-center mb-3">
                    <img className="thumbnail" width={300} src="/assets/logo-full.png" alt='' />
                </div>
                {data.children}
                <div className="d-flex justify-content-center mt-3">
                    <LanguageSwitcher />
                </div>
            </div>
        </div>
    </div>
}