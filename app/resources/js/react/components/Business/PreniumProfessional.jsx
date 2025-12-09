import React from 'react'
import FlatIcon32 from '../UI/FlatIcons/FlatIcon32'
export default function PreniumProfessional() {
    return <div className="card border-0 rounded-3 p-4 theme-bg theme-title-highlight">
        <h5 className="fw-bold mb-4">Professional <span className='badge bg-success'>19.9$</span></h5>

        <div className="row">
            <div className="col-md-6">
                <ul className="list-unstyled mb-0">
                    <li className="d-flex align-items-center">
                        <FlatIcon32 name='checked' size={18}/>
                        <p className='mt-3 mx-2 theme-text'>1 công ty, 2 chi nhánh và 4 kho</p>
                    </li>
                </ul>
            </div>

            <div className="col-md-6">
                <ul className="list-unstyled mb-0">
                    <li className="d-flex align-items-center">
                        <FlatIcon32 name='checked' size={18}/>
                        <p className='mt-3 mx-2 theme-text'>Hỗ trợ ưu tiên 24/7</p>
                    </li>
                </ul>
            </div>
        </div>
        <div className="row">
            <div className="col-md-6">
                <ul className="list-unstyled mb-0">
                    <li className="d-flex align-items-center">
                        <FlatIcon32 name='checked' size={18}/>
                        <p className='mt-3 mx-2 theme-text'>Tối đa 10 tài khoản sử dụng</p>
                    </li>
                </ul>
            </div>

            <div className="col-md-6">
                <ul className="list-unstyled mb-0">
                    <li className="d-flex align-items-center">
                        <FlatIcon32 name='checked' size={18}/>
                        <p className='mt-3 mx-2 theme-text'>Báo cáo chi tiết</p>
                    </li>
                </ul>
            </div>
        </div>
        <div className="row">
            <div className="col-md-6">
                <ul className="list-unstyled mb-0">
                    <li className="d-flex align-items-center">
                        <FlatIcon32 name='checked' size={18}/>
                        <p className='mt-3 mx-2 theme-text'>API không giới hạn</p>
                    </li>
                </ul>
            </div>

            <div className="col-md-6">
                <ul className="list-unstyled mb-0">
                    <li className="d-flex align-items-center">
                        <FlatIcon32 name='checked' size={18}/>
                        <p className='mt-3 mx-2 theme-text'>Tích hợp bên thứ ba</p>
                        
                    </li>
                </ul>
            </div>
        </div>
    </div>

}