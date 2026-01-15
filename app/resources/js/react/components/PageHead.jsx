import React from 'react'
import { useI18n } from '../../i18n/useI18n'
export default function PageHead({
    title = 'Title',
    subtitle = 'Subtitle',
    containerClass = 'container'
}){
    const {t} = useI18n();
    return <div className='theme-card pt-2 pb-2 border-bottom'>
        <div className={containerClass}>
            <h2 className='h4 theme-title-highlight'>{t(title)}</h2>
            <p>{t(subtitle)}</p>
        </div>
    </div>
}