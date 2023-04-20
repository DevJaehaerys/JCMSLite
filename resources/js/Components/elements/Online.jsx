import { useState, useEffect } from 'react';

const ServerStatus = () => {
    const [playerCount, setPlayerCount] = useState(null);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchPlayerCount = async () => {
            try {
                const response = await fetch('/api/online');
                if (!response.ok) {
                    throw new Error('Back-end error');
                }
                const data = await response.json();
                setPlayerCount(data);
                setError(null);
            } catch (error) {
                console.error(error);
                setPlayerCount(null);
                setError('Server not available');
            }
        };
        fetchPlayerCount();
        const intervalId = setInterval(fetchPlayerCount, 30000);

        return () => clearInterval(intervalId);
    }, []);

    return (
        <div>
            {error ? error : (playerCount === null ? 'Loading...' : `Players Online: ${playerCount}`)}
        </div>
    );
};

export default ServerStatus;
