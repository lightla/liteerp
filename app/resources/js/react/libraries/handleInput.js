import { useMemo, useState } from "react";

export function useForm() {
    const [formData, setFormData] = useState(null);
    const [formErrors, setFormErrors] = useState(null);
    const [loading, setLoading] = useState(false);
    const [isEdit, setIsEdit] = useState(false);
    const [isDestroy, setIsDestroy] = useState(false);

    const handleChange = (e) => {
        const { name, type, value, checked } = e.target;

        setFormData(prev => ({
            ...prev,
            [name]: type === "checkbox" ? checked : value,
        }));
    };

    const handleChangeByKey = (name,value) => {
        setFormData(prev => ({
            ...prev,
            [name]: value,
        }));
    };

    const resetForm = () => setFormData(initial);
    useMemo(() => {
        if (isEdit) {
            setIsDestroy(false)
        }
        if (!isEdit) {
            setFormData(null)
        }
        setFormErrors(null)
    }, [isEdit])
    useMemo(() => {
        if (isDestroy) {
            setIsEdit(false)
        }
        if (!isDestroy) {
            setFormData(null)
        }
        setFormErrors(null)
    }, [isDestroy])
    return {
        formData,
        setFormData,
        formErrors,
        setFormErrors,
        handleChange,
        resetForm,
        loading,
        setLoading,
        isEdit,
        setIsEdit,
        handleChangeByKey
    };
}
