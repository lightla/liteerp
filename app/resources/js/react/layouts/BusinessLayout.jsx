import React from 'react';
import { useDispatch, useSelector } from "react-redux";
export default function AuthLayout(data = {
    children
}){
    const theme = useSelector((state) => state.theme.mode);
    return <div className='business-layout' data-theme={theme}>
        {data.children}
    </div>
}