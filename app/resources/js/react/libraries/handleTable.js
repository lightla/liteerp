import { useState } from "react";

export default function useTable(){
    const [data,setData] = useState([]);
    const [links,setLinks] = useState([]);
    const [loading,setLoading] = useState(false);
    const [total,setTotal] = useState(0);
    const [colums,setColums] = useState([]);
    return {
        data,
        setData,
        links,
        setLinks,
        loading,
        setLoading,
        total,
        setTotal,
        colums,
        setColums
    }
}