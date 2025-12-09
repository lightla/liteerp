import React, { useCallback, useEffect, useMemo, useRef, useState } from "react";
import Select from "react-select";
import { InputForm } from "./InputForm";

export default function SearchSelect({
  options = [],
  search = (text) => { },
  changeValue = (key,value) => { },
  value = null,
  disabled = false,
  errorMessage = null,
  defaultKeywords = '',
  name = '',
  placeholder = 'Search...'
}) {
  const historyKeyword = useRef('');
  const keywords = useRef('');
  const [wait, setWait] = useState(false);
  const [localValue,setLocalValue] = useState(null);
  useMemo(() => {
    if (wait || historyKeyword.current === keywords.current) {
      return;
    }
    search(keywords.current);
    historyKeyword.current = keywords.current;
    
  }, [keywords.current, search, wait,historyKeyword]);
  useMemo(() => {
    if(options.length === 0 && defaultKeywords !== '') {
        keywords.current = defaultKeywords;
    }
    options.map((item) => {
      if(value === item.value) {
        setLocalValue(item);
        keywords.current = item.label;
      }
    })
  },[options,keywords.current])
  return (
    disabled ? <div>
      <InputForm disabled={true} value={localValue?.label} />
    </div> :
      <div>
        <Select
          disabled={disabled}
          value={localValue}
          onInputChange={(text) => {
            if (keywords.current === text) {
              return;
            }
            keywords.current = text;
            if (wait) {
              return;
            }
            if (wait === false) {
              setWait(true);
            }
            setTimeout(() => {
              setWait(false);
            }, 1000);
          }}
          onChange={(item) => {
            setLocalValue(item);
            changeValue(name,item.value)
          }}
          options={options}
          placeholder={placeholder}
          className={(errorMessage ? 'is-invalid' : '')}
        />
        {errorMessage ? <div className="invalid-feedback">
          {errorMessage.map((mess, index) => {
            return <p key={index}>{mess}</p>
          })}
        </div> : null}
      </div>
  );
}
