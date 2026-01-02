import React from 'react'
import LoadImage from './LoadImage'
export default function RenderFieldTableByList({
    item = null,
    data = null
}) {
    return <div>
        {item?.type === 'badge' ?
            <div className={'badge badge-' + item.value}>{data}</div>
            : item?.type === 'text' ?
                <span>{data}</span>
                : item?.type === 'image' ?
                    <LoadImage
                        url={data}
                        width={50}
                        height={50}
                    />
                    : item?.type === 'html' ?
                        <div dangerouslySetInnerHTML={{ __html: data }} ></div>
                    : item?.type === 'link' ?
                        <div>
                            <a href={data} target='_blank' >{item.label}</a>
                        </div>
                    : null}
    </div>
}