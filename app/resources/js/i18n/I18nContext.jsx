import React, { createContext, useEffect, useState } from "react";
import en from "./locales/en";
import vi from "./locales/vi";
import ja from "./locales/ja";

const dictionaries = { en, vi, ja };

export const I18nContext = createContext({
  lang: "en",
  t: (key) => key,
  setLang: () => {},
});

export const I18nProvider = ({ children }) => {
  const [lang, setLang] = useState(
    localStorage.getItem("lang") || "en"
  );

  useEffect(() => {
    localStorage.setItem("lang", lang);
  }, [lang]);

  const t = (key) => {
    return (
      key
        .split(".")
        .reduce((obj, k) => (obj ? obj[k] : null), dictionaries[lang]) ||
      key
    );
  };

  return (
    <I18nContext.Provider value={{ lang, t, setLang }}>
      {children}
    </I18nContext.Provider>
  );
};
