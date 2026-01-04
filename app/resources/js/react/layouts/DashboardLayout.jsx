import React, { useCallback, useEffect } from 'react'
import Sidebar from "../components/Sidebar";
import Topbar from "../components/Topbar";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from 'react-router-dom';
import BusinessRoleService from '../services/BusinessRoleService'
import { setBusinessNav } from '../redux/businessRoleSlice';
export default function DashboardLayout({
    children
}) {
    const navigate = useNavigate();
    const nav = useSelector((state) => state.businessRole.nav);
    const business = useSelector((state) => state.business.data);
    const theme = useSelector((state) => state.theme.mode);
    const dispatch = useDispatch();
    const businessRole = useCallback(() => {
        BusinessRoleService.view()
            .then((resp) => {
                dispatch(setBusinessNav(resp.message.nav))
            })
            .catch((error) => {

            })
    }, [dispatch])
    useEffect(() => {
        if (!business) {
            navigate("/business");
        }
        if(!nav) {
            businessRole();
        }
    }, [business,nav]);
    return <div className={"container-fuild dashboard-megabox dark-theme "} data-theme={theme}>
        <div className="row">
            <div className="col-lg-2 col-md-3 col-sm-4 px-0">
                <Sidebar />
            </div>
            <div className="col-lg-10 col-md-9 col-sm-8 px-0 dashboard-content">
                <Topbar />
                <div>
                    {children}
                </div>
            </div>
        </div>
    </div>
}