import React from "react";

export default function PrimaryButton({ 
  label = "Primary Button", 
  onClick = null, 
  disabled = false,
  loading = false
}) {
  return (
    <button disabled={disabled || loading} className="erp-btn erp-btn-primary" onClick={onClick}>
      {label}
    </button>
  );
}
