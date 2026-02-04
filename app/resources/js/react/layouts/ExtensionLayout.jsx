import React, { useCallback, useEffect } from 'react'
import { useDispatch, useSelector } from "react-redux";
export default function ExtensionLayout({
    children
}) {
    const theme = useSelector((state) => state.theme.mode);
    return <div className={"container-fuild dashboard-megabox dark-theme "} data-theme={theme}>
        <div className="mb-5">
            {children}
        </div>
        <footer className="border-top bg-white mt-5">
            <div className="container-fluid py-2">
                <div className="row align-items-center text-muted small">
                    <div className="col-md-4 d-flex align-items-center gap-2 justify-content-center justify-content-md-start">
                        <i className="bi bi-box"></i>
                        <span>LiteERP © 2026</span>
                    </div>
                    <div className="col-md-8 d-flex align-items-center gap-3 justify-content-center justify-content-md-end">
                        <a href="https://github.com/liteerp-oss/liteerp" target="_blank"
                            className="text-muted text-decoration-none d-flex align-items-center gap-1 hover-opacity">
                            <i className="bi bi-github"></i>
                            Github
                        </a>

                        <a href="https://github.com/liteerp-oss/docs"
                            className="text-muted text-decoration-none d-flex align-items-center gap-1">
                            <i className="bi bi-book"></i>
                            Docs
                        </a>

                        <a href="https://github.com/liteerp-oss/liteerp/issues"
                            className="text-muted text-decoration-none d-flex align-items-center gap-1">
                            <i className="bi bi-life-preserver"></i>
                            Support
                        </a>
                    </div>

                </div>
            </div>
        </footer>


    </div>
}