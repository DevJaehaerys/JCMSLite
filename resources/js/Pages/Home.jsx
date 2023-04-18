import Page from "@/Layouts/Page";
import Shopcard from "@/Components/elements/shopcard";
function Home({auth, shop}) {
    return (
        <Page auth={auth} name="Home">
            <div className="hero">
                <div>
                    <Shopcard auth={auth} shop={shop}/>
                </div>
            </div>
        </Page>
    );
}

export default Home;
