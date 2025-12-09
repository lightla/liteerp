import React from 'react'
export default function TextArea({
    className= '',
    placeholder= '',
    errorMessage = null,
    handleChange= (text) => {},
    value= '',
    name = 'textarea',
    disabled = false
}){
    return <div>
        <textarea 
        disabled={disabled}
        value={value}
        onChange={handleChange}
        name={name}
        placeholder={placeholder} className={"form-control default-input " + (className ?? '') + (errorMessage ? 'is-invalid' : '')} ></textarea>
        {errorMessage ? <div className="invalid-feedback">
            {errorMessage.map((mess,index) => {
                return <p key={index}>{mess}</p>
            })}
        </div> : null }
    </div>
}