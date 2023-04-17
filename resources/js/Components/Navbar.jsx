import ThemeSwitcher from "@/Context/ThemeSwitcher";
import LinkList from "@/Components/elements/LinkList";
import AuthDropdown from "@/Components/elements/AuthDropdown";

function Navbar({auth}) {
    const isAuthenticated = auth !== null;
    return (
        <nav>
            <div className="navbar">
                <div className="navbar-start">
                    <a className="btn btn-ghost normal-case text-xl">JCMS Lite</a>
                </div>
                <div className="navbar-center hidden lg:flex">
                    <ul className="menu menu-horizontal px-1">
                        <LinkList/>
                    </ul>
                </div>
                <div className="block lg:hidden">
                    <div className="navbar-start">
                        <div className="dropdown">
                            <label tabIndex={0} className="btn btn-ghost btn-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                            </label>
                            <ul tabIndex={0} className="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                                <LinkList/>

                            </ul>
                        </div>
                    </div>
                </div>

                {isAuthenticated ? (
                    <div className="navbar-end z-50">
                        <ThemeSwitcher/>
                        <AuthDropdown auth={auth}/>
                    </div>
                ) : (
                    <div className="navbar-end z-50">
                        <a href="/login/steam" className="btn">Auth</a>
                    </div>
                )}
            </div>
        </nav>
    );
}

export default Navbar;
