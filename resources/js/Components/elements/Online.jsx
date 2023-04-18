import { useState, useEffect } from 'react';

const ServerStatus = () => {
    const [playerCount, setPlayerCount] = useState(null);

    useEffect(() => {
        const fetchPlayerCount = async () => {
            try {
                const response = await fetch('https://api.battlemetrics.com/servers/6803740');
                const data = await response.json();
                setPlayerCount(data.data.attributes.players);
            } catch (error) {
                console.error(error);
            }
        };

        fetchPlayerCount();
        const intervalId = setInterval(fetchPlayerCount, 30000);

        return () => clearInterval(intervalId);
    }, []);

    return (
        <div>
            {playerCount === null ? 'Loading...' : `Players Online: ${playerCount}`}
        </div>
    );
};

export default ServerStatus;
