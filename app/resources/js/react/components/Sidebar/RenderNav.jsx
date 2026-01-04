import React from 'react'
import { NavLink } from 'react-router-dom'
export default function RenderNav({
    list = []
}) {
    return list.map((item,index) => {
        return <li className="nav-item mb-2" key={index}>
          <NavLink to={item.to} className="erp-link">
            <div className='row'>
              <div className='col-3'>
                <i className={item.icon}/>
              </div>
              <div className='col-6 ml-2'>
                {item.label}
              </div>
            </div>
          </NavLink>
        </li>
    })
}