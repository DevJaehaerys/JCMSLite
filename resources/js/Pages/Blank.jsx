import Page from "@/Layouts/Page";
function Blank({auth}) {
    return (
        <Page auth={auth} name="Home">
            <div className="hero">
                <div>
                    <h1>Blank page</h1>
                </div>
            </div>
        </Page>
    );
}

export default Blank;
