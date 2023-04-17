import Links from "@/Data/Links";
import { Link } from '@inertiajs/react';
import { useState, useEffect } from 'react';

function LinkList() {
    const [isHorizontal, setIsHorizontal] = useState(false);

    useEffect(() => {
        const mediaQuery = window.matchMedia('(max-width: 1024px)');
        setIsHorizontal(!mediaQuery.matches);

        const handleChange = (e) => setIsHorizontal(!e.matches);
        mediaQuery.addEventListener('change', handleChange);

        return () => mediaQuery.removeEventListener('change', handleChange);
    }, []);

    return (
        <ul className={`menu ${isHorizontal ? 'menu-horizontal' : ''} px-1`}>
            {Links.map((link) => (
                <li key={link.link}>
                    <Link href={link.link} preserveState>{link.name}</Link>
                </li>
            ))}
        </ul>
    );
}

export default LinkList;
