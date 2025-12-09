import React from 'react'
export default function PageHead({
    title = 'Title',
    subtitle = 'Subtitle',
    containerClass = 'container'
}){
    return <div className='theme-card pt-2 pb-2 border-bottom'>
        <div className={containerClass}>
            <h2 className='h4 theme-title-highlight'>{title}</h2>
            <p>{subtitle}</p>
        </div>
    </div>
}