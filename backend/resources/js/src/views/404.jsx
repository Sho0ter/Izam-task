import { Link } from 'react-router-dom';

export default function NotFound() {
    return (
        <div className="mx-auto flex size-full max-w-3xl flex-col">
        <header className="z-50 mb-auto flex w-full justify-center py-4">
            <nav className="px-4 sm:px-6 lg:px-8">
                <Link
                    to={{
                        pathname: '/',
                    }}
                    className="flex-none text-xl font-semibold sm:text-3xl"
                    aria-label="Brand"
                >
                    Brand
                </Link>
            </nav>
        </header>

        <main>
            <div className="px-4 py-10 text-center sm:px-6 lg:px-8">
                <h1 className="block text-7xl font-bold text-gray-800 sm:text-9xl">404</h1>
                <p className="mt-3 text-gray-600">Oops, something went wrong.</p>
                <p className="text-gray-600">Sorry, we couldn't find your page.</p>
                <div className="mt-5 flex flex-col items-center justify-center gap-2 sm:flex-row sm:gap-3">
                    <Link
                        to={{ pathname: '/' }}
                        className="inline-flex w-full items-center justify-center gap-x-2 rounded-lg border border-transparent bg-blue-600 px-4 py-3 text-sm font-medium text-white hover:bg-blue-700 focus:bg-blue-700 focus:outline-hidden disabled:pointer-events-none disabled:opacity-50 sm:w-auto"
                    >
                        <svg
                            className="size-4 shrink-0"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth="2"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                        >
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                        Back to examples
                    </Link>
                </div>
            </div>
        </main>

        <footer className="mt-auto py-5 text-center">
            <div className="mx-auto max-w-[85rem] px-4 sm:px-6 lg:px-8">
                <p className="text-sm text-gray-500">© All Rights Reserved. 2022.</p>
            </div>
        </footer>
    </div>
    );
}
