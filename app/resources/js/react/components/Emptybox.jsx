import React from 'react'
import FlatIcon32 from './UI/FlatIcons/FlatIcon32'

export default function EmptyBox({
    message = ''
}) {
    return (
        <div className="d-flex justify-content-center align-items-center w-100 h-100">
            <div className='mt-5 text-center'>
                <h4 className='h6'>Empty data</h4>
                <FlatIcon32 size={64} name='empty-box' />
                <div className='theme-title'>
                    {message ?? ''}
                </div>
            </div>
        </div>
    )
}
