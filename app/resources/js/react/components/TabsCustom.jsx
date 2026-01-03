import React from 'react'
export default function TabsCommon({
    navs = [],
    contents = []
}) {
    return <div>
        <ul className="nav nav-tabs" id="myTab" role="tablist">
            {navs.map((item,index) => {
                return <li key={index} className="nav-item" role="presentation">
                    <button className={"nav-link " + (index === 0 ? 'active' : '')} id={item.key + "-tab"} data-bs-toggle="tab" 
                    data-bs-target={"#" + item.key} type="button" role="tab" 
                    aria-controls={item.key} 
                    aria-selected={(index === 0 ? 'true' : 'false')}>{item.label}</button>
                </li>
            })}
        </ul>
        <div className="tab-content" id="myTabContent">
            {navs.map((item,index) => {
                return <div key={index} 
                className={"mt-2 tab-pane fade " + (index === 0 ? ' show active' : '')} id={item.key} role="tabpanel" 
                aria-labelledby={item.key + "-tab"}>
                    {contents[index]}
                </div>
            })}
            
        </div>
    </div>
}