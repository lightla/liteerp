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
        if (!nav) {
            businessRole();
        }
    }, [business, nav]);
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
        <footer class="border-top bg-white">
  <div class="container-fluid py-2">
    <div class="row align-items-center text-muted small">
      <div class="col-md-4 d-flex align-items-center gap-2 justify-content-center justify-content-md-start">
        <i class="bi bi-box"></i>
        <span>LiteERP © 2026</span>
      </div>
      <div class="col-md-8 d-flex align-items-center gap-3 justify-content-center justify-content-md-end">
        <a href="https://github.com/liteerp-oss/liteerp" target="_blank"
           class="text-muted text-decoration-none d-flex align-items-center gap-1 hover-opacity">
          <i class="bi bi-github"></i>
          Github
        </a>

        <a href="https://github.com/liteerp-oss/docs"
           class="text-muted text-decoration-none d-flex align-items-center gap-1">
          <i class="bi bi-book"></i>
          Docs
        </a>

        <a href="https://github.com/liteerp-oss/liteerp/issues"
           class="text-muted text-decoration-none d-flex align-items-center gap-1">
          <i class="bi bi-life-preserver"></i>
          Support
        </a>
      </div>

    </div>
  </div>
</footer>


    </div>
}