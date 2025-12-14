import React from "react"

export default function StatusBadge({
    status = null 
}){
    return <span className={"badge text-uppercase rounded-pill px-3 py-2 badge-" + status}>{status}</span>
}