import React, { useCallback, useEffect, useRef, useState } from 'react'
import DashboardLayout from '../layouts/DashboardLayout'
import PageHead from '../components/PageHead'
import ExtensionService from '../services/ExtensionService';
import ExtensionCard from '../components/Extension/ExtensionCard';
import { InputForm } from '../components/UI/Input/InputForm'
import {usePopup} from '../components/popups/PopupContext'
import LoadingBox from '../components/LoadingBox'
import EmptyBox from '../components/Emptybox'
export default function Extensions() {
    let fileRef = useRef(null);
    const [loading,setLoading] = useState(false)
    const { openPopup } = usePopup();
    const [extensions, setExtensions] = useState([]);
    const list = useCallback(() => {
        setLoading(true)
        ExtensionService.list({})
            .then((resp) => {
                setExtensions(resp.message);
                setLoading(false)
            })
            .catch((error) => {
                setLoading(false)
            })
    }, []);
    const uploadExtension = useCallback(() => {
        let form = new FormData();
        form.append('file',fileRef.current.files[0]);
        ExtensionService.add(form)
        .then((resp) => {
            openPopup({
                type: 'success',
                message: 'You has been uploaded'
            })
            setExtensions([])
            list();
            
        })
        .catch((error) => {
            if(error.response?.data?.message) {
                openPopup({
                    type: 'error',
                    message: error.response?.data?.message
                })
            }
        })
    },[fileRef,list])
    const upload = () => {
        fileRef.current.click();
    }
    useEffect(() => {
        list()
    }, [])
    return <DashboardLayout>
        <div>
            <PageHead title='Extension'
                subtitle='Manage extension'
            />
            <div className=''>
                <div className='border-bottom'>
                    <div className='container'>
                        <div className='row mb-2 pt-3 pb-2 px-1'>
                            <div className='col-8'>
                                <div className='d-flex'>
                                    <h4>All extensions</h4>
                                    <small className='mt-1 mx-3 badge bg-primary text-white'
                                        style={{
                                            height: 20
                                        }} onClick={upload} >Upload</small>
                                        <input onChange={uploadExtension} ref={fileRef} type='file' id='file' style={{
                                            display: 'none'
                                        }} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className='container mt-3'>
                    <div className='row'>
                        {loading ?<LoadingBox/>: null }
                        {extensions.map((item, index) => {
                            return <div className='col-4 mb-3' key={index}>
                                <ExtensionCard item={item} />
                            </div>
                        })}
                        {extensions.length === 0 ? <EmptyBox message='Please install extensions'/> : null}
                    </div>

                </div>
            </div>
        </div>
    </DashboardLayout>
}