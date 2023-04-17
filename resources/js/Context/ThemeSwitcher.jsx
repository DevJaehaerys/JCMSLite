import React, { useState, useEffect } from "react";

const ThemeSwitcher = () => {
    const [theme, setTheme] = useState(
        localStorage.getItem("theme") || "business"
    ); // Сначала пытаемся получить сохраненную тему из localStorage, если ее нет, используем тему по умолчанию - "light"
    const [themes] = useState([
        "light",
        "dark",
        "cupcake",
        "bumblebee",
        "emerald",
        "corporate",
        "synthwave",
        "retro",
        "cyberpunk",
        "valentine",
        "halloween",
        "garden",
        "forest",
        "aqua",
        "lofi",
        "pastel",
        "fantasy",
        "wireframe",
        "black",
        "luxury",
        "dracula",
        "cmyk",
        "autumn",
        "business",
        "acid",
        "lemonade",
        "night",
        "coffee",
        "winter",
    ]);

    useEffect(() => {
        document.documentElement.setAttribute("data-theme", theme); // Меняем атрибут data-theme у тега <html>, чтобы применить выбранную тему
        localStorage.setItem("theme", theme); // Сохраняем выбранную тему в localStorage
    }, [theme]);

    const handleThemeChange = (selectedTheme) => {
        setTheme(selectedTheme);
    };

    return (
        <div>
            <div className="dropdown">
                <label tabIndex={0} className="btn m-1">Themes</label>

                <ul tabIndex={0} className="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-32">
                    {themes.map((t) => (

                        <li key={t}
                            onClick={() => handleThemeChange(t)}
                            className={`theme-switcher-button ${
                                theme === t ? "active" : ""
                            }`}
                        >
                            {t}
                        </li>
                    ))}
                </ul>
            </div>
            <div>


            </div>
        </div>
    );
};

export default ThemeSwitcher;
