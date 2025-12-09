import React, { useState, useEffect } from "react";
export default function GradientButton({
    text= 'Submit',
    callback= () => {},
    width= 150,
    loading = false,
    disabled = false
}){
    return <button 
    disabled={loading || disabled}
    style={{
        width: width
    }}
    onClick={callback}
    className="default-button erp-btn">{text}</button>
}