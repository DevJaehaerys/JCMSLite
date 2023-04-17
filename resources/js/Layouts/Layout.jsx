import Navbar from "@/Components/Navbar";
import Footer from "@/Components/Footer";

const Layout = ({ children, auth }) => {

    return (
        <div className="flex flex-col min-h-screen">
            <div className="background">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <Navbar auth={auth} />
            <div className="flex-grow mt-32 z-10">{children}</div>
            <Footer />
        </div>

    );
};

export default Layout;
