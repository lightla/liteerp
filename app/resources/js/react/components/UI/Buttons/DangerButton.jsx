import React from "react";

export default function DangerButton({ 
  label = "Danger Button", 
  onClick = null, 
  disabled = false,
  loading = false
}) {
  return (
    <button 
    disabled={disabled || loading}
    className="erp-btn erp-btn-danger" onClick={onClick}>
      {label}
    </button>
  );
}
