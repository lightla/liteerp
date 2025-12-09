import React from "react";
import SecondaryButton from "../components/UI/Buttons/SecondaryButton";
import SuccessButton from "../components/UI/Buttons/SuccessButton";

export function PopupLayout({ onClose = null, 
  title = '', onConfirm = null, 
  confirmText = 'Add new', children,
  loading = false }) {
  return (
    <div
      className={`modal fade show d-block`}
      tabIndex="-1"
      role="dialog"
      style={{ backgroundColor: "rgba(0,0,0,0.6)" }}
    >
      <div className="modal-dialog modal-dialog-centered modal-md" role="document">
        <div className="modal-content theme-bg theme-title border-0 rounded-3 shadow-lg">
          <div className="modal-header border-secondary">
            <h5 className="modal-title fw-semibold theme-title-highlight">{title}</h5>
            <button
              disabled={loading}
              type="button"
              className="btn-close theme-title"
              aria-label="Close"
              onClick={onClose}
            ></button>
          </div>

          <div className="modal-body">
            {children}
          </div>

          <div className="modal-footer border-secondary">
            <SecondaryButton loading={loading} label="Cancel" onClick={onClose} />
            <SuccessButton loading={loading} onClick={onConfirm} label={confirmText} />

          </div>
        </div>
      </div>
    </div>
  );
}
