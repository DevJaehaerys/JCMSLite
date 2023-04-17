import { Head } from '@inertiajs/react';
import Layout from '@/Layouts/Layout';
import Links from '@/Data/Links';
const Page = ({ name, children, auth }) => {
    const link = Links.find((l) => l.name.toLowerCase() === name.toLowerCase());
    const title = link ? link.title : 'Untitled Page';
    const description = link ? link.description : '';

    return (
            <Layout auth={auth}>
                <Head>
                    <title>{title}</title>
                    <meta name="description" content={description} />
                </Head>
                <h1 className="text-4xl text-center">{title}</h1>
                {children}
            </Layout>
    );
};

export default Page;
