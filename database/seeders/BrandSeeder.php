<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => '3M',
                'description' => 'Innovation that sticks with you: premium solutions from 3M',
                'logo' => 'brands/EJeG5LyMVUcVoA5FXsScavemaeFApSryasIVhwqm.png',
                'website' => 'https://www.3m.com/',
            ],
            [
                'name' => 'A4 Tech',
                'description' => 'Connect smarter with A4 Techs quality peripherals',
                'logo' => 'brands/mjdFlWlrlWzkJ932PbKkOTIRK6KIieT0Pgi21G4G.jpg',
                'website' => 'https://www.a4tech.com/',
            ],
            [
                'name' => 'Acer',
                'description' => 'Power your ideas with Acers cutting-edge laptops and PCs',
                'logo' => 'brands/cO1oDJZRfkQ5YZQqBkyTHPfKSeqQ7xuVW6qQVDeg.jpg',
                'website' => 'https://www.acer.com/',
            ],
            [
                'name' => 'Adata',
                'description' => 'Speed meets reliability with Adata storage solutions',
                'logo' => 'brands/q2WwqaaQf078zP1azqardEwrXOLGEiwKY6FSgkIF.png',
                'website' => 'https://www.adata.com',
            ],
            [
                'name' => 'Amd',
                'description' => 'Unleash ultimate performance with AMD processors and graphics',
                'logo' => 'brands/3DrDp8ELfMQNQ34GnoSVDFRMP5tlwol8VNcntdtD.png',
                'website' => 'https://www.amd.com',
            ],
            [
                'name' => 'Asus',
                'description' => 'Inspiring innovation, Asus brings your tech to life',
                'logo' => 'brands/926hHGXydkg96gzD0cJhxwYUBkjBATmwLhKFCtAp.png',
                'website' => 'https://www.asus.com/',
            ],
            [
                'name' => 'Asus- Notebooks',
                'description' => 'Elevate productivity with Asus Notebooks, engineered for you',
                'logo' => 'brands/bqQoIQED5S7dZUnccA6uawiGzOD4rUFZorRqRB6e.png',
                'website' => 'https://www.asus.com/',
            ],
            [
                'name' => 'Baseus',
                'description' => 'Stylish, smart, and practical – Baseus tech accessories',
                'logo' => 'brands/lGXckvw4pBvU4H92geNWj2VK3nJ4dRDAPwTxNjcv.png',
                'website' => 'https://www.baseus.com/',
            ],
            [
                'name' => 'Benq',
                'description' => 'Visual perfection with BenQ monitors and projectors',
                'logo' => 'brands/L25Bsquc1MHyHxLPf32VWPVukOKsqaLPBgiI3WkS.png',
                'website' => 'https://www.benq.com',
            ],
            [
                'name' => 'Biostar',
                'description' => 'Stability and performance for your computing needs – Biostar',
                'logo' => 'brands/YGEhLRWoIMxWkM7SIi5YU8jTDpbLqKzv5XjHnc9K.png',
                'website' => 'https://www.biostar.com.tw',
            ],
            [
                'name' => 'Bixolon',
                'description' => 'Print smart, print fast with Bixolon solutions',
                'logo' => 'brands/WHvZkwUIjlsktkBc30GZlbro268JD5NXCvpq2lqT.jpg',
                'website' => 'https://www.bixolon.com/',
            ],
            [
                'name' => 'Borl',
                'description' => 'Reliability in every device – trust Borl technology',
                'logo' => null,
                'website' => null,
            ],
            [
                'name' => 'Brother',
                'description' => 'Brother brings professional printing and office solutions',
                'logo' => 'brands/nLGE6MjOcRk5m5u6kAQUANZOs0N5TAeYIhnp9Kpy.webp',
                'website' => 'https://www.brother.com.lk/en',
            ],
            [
                'name' => 'C-Net',
                'description' => 'Networking made simple with C-Net devices',
                'logo' => 'brands/8XmCmZ2ExkqWh2hfucAZTWYKwhr9ABgIrV11lNWl.png',
                'website' => 'https://www.cnetsystems.com/',
            ],
            [
                'name' => 'Canon',
                'description' => 'Capture life perfectly with Canon imaging solutions',
                'logo' => 'brands/8gKfGZmHnCl6e2Mv2f8MgpNAaIdAOmnUWO1MdSdZ.png',
                'website' => 'https://global.canon/en/',
            ],
            [
                'name' => 'Cooler Master',
                'description' => 'Keep your cool with Cooler Master high-performance cooling and cases',
                'logo' => 'brands/sth64ezye94BlTPihzH15rEMWKloSkXQBEN7Agu7.webp',
                'website' => 'https://www.coolermaster.com/en-global/',
            ],
            [
                'name' => 'Corsair',
                'description' => 'Gaming power and precision – Corsair has you covered',
                'logo' => 'brands/6Tlsv6YKC2bh7nsdsQ2xYbfQcgsCNWYMymT5pQuO.webp',
                'website' => 'https://www.corsair.com/',
            ],
            [
                'name' => 'D Link',
                'description' => 'Smart connectivity, everywhere – D-Link networking',
                'logo' => 'brands/YPUWrrs1GnJZlOffSISM0JGBvR1hJtYjqEOvZR2F.jpg',
                'website' => 'https://www.dlink.com/en',
            ],
            [
                'name' => 'Dcp',
                'description' => 'Dependable printing solutions by DCP',
                'logo' => 'brands/97bun40uPqoDMVO7zp2Zr7B8GFCU4lLZSgroNpBc.jpg',
                'website' => 'https://debugstore.lk/',
            ],
            [
                'name' => 'Dell',
                'description' => 'Engineered for success – premium Dell computers and laptops',
                'logo' => 'brands/f4PnICxACQ2aT9rcnGQSl02MWrIufFfTQivyNOeN.jpg',
                'website' => 'https://www.dell.com/en-us',
            ],
            [
                'name' => 'E-Box',
                'description' => 'Innovative tech made simple – E-Box solutions',
                'logo' => null,
                'website' => null,
            ],
            [
                'name' => 'Epson',
                'description' => 'Printing excellence for home and office – Epson',
                'logo' => 'brands/JMJ2MJCTyQJwa3KlV4hshws4GKcjyFstrLBJVGY4.png',
                'website' => 'https://epson.com',
            ],
            [
                'name' => 'Eset',
                'description' => 'Protect what matters with ESET cybersecurity solutions',
                'logo' => 'brands/uSs5tZpXxBIHyCtGZqv4cF58nfos6dlI1i7w5jlo.webp',
                'website' => 'https://www.eset.com/',
            ],
            [
                'name' => 'Esonic',
                'description' => 'Audio clarity meets technology – Esonic products',
                'logo' => 'brands/9vKp3H7WZitNWr0eacQCxwJ4VxICCAWuvQrteoKp.jpg',
                'website' => 'https://www.esonic.cn/',
            ],
            [
                'name' => 'Ezcool',
                'description' => 'Keep cool, stay efficient – EZCool systems',
                'logo' => 'brands/ge4s9s8ESU0KQLZy0BtxwIsoIhU5OTeziUL5Kv0U.png',
                'website' => 'http://www.ezcool.com.tw/',
            ],
            [
                'name' => 'Gigabyte',
                'description' => 'Game on with Gigabyte motherboards and graphics',
                'logo' => 'brands/N5pSkpmQaL7lvcV7MrANIAtDSVGKZYbqcTKuv4Q4.png',
                'website' => 'https://www.gigabyte.com/',
            ],
            [
                'name' => 'Hp',
                'description' => 'Reinvent your workspace with HP computers and printers',
                'logo' => 'brands/Di7kOh0gFbrhfkYZW6cSqU2gkId4321wsXBDLNjM.png',
                'website' => 'https://www.hp.com/',
            ],
            [
                'name' => 'Huawei',
                'description' => 'Connecting the world with Huaweis cutting-edge devices',
                'logo' => 'brands/JxcrdIreFSpfyf9kOcPbBgdbjVBfuujv3Q1GitYI.png',
                'website' => 'https://www.huawei.com/en/',
            ],
            [
                'name' => 'Imation',
                'description' => 'Data storage solutions you can trust – Imation',
                'logo' => 'brands/5hiOhYWKvACXhfufliPtFFaVUKv68qzn3yVPLphW.jpg',
                'website' => 'http://www.imation.com/en/',
            ],
            [
                'name' => 'Intel',
                'description' => 'Powering progress – Intel processors for every PC',
                'logo' => 'brands/RawrhoGe8edsxGtyLKfN1XHntzeysfI7SbJj4po0.png',
                'website' => 'https://www.intel.com/',
            ],
            [
                'name' => 'Jbl',
                'description' => 'Feel every beat with JBL audio excellence',
                'logo' => 'brands/DIAs5bxJ7KjDFlsdXfo8dypzexrKzgJ0GNt5ZDJT.jpg',
                'website' => 'https://www.jbl.com',
            ],
            [
                'name' => 'Kaspersky',
                'description' => 'Security you can trust – Kaspersky protects your digital life',
                'logo' => 'brands/ziv5tRBqdnsmKBXxv4i3bo7gzbfQJW7N8KzpBIhw.jpg',
                'website' => 'https://www.kaspersky.com/',
            ],
            [
                'name' => 'Kingston',
                'description' => 'Memory that moves you forward – Kingston products',
                'logo' => 'brands/AzsNUtfzyxRJaAH3dus5E2ISe4wImjZUV0q9NJ0F.jpg',
                'website' => 'https://www.kingston.com/',
            ],
            [
                'name' => 'Lenovo',
                'description' => 'Smarter technology for all – Lenovo laptops and PCs',
                'logo' => 'brands/fVsh9eY69avRYIaV3JYZYStN6Aonap4lFs3uF4gv.png',
                'website' => 'https://www.lenovo.com',
            ],
            [
                'name' => 'Logitech',
                'description' => 'Designed for play, work, and life – Logitech peripherals',
                'logo' => 'brands/ZbCwPVnEYsESh49Vbgn2HoCsErIMjD8VxzK3iGmk.png',
                'website' => 'https://www.logitech.com',
            ],
            [
                'name' => 'Microlab',
                'description' => ' Audio that inspires – Microlab speakers and sound systems',
                'logo' => 'brands/3vc8gxlSKcFkrDx6YzTXRqwPxE7wnObEuV7Yr5aE.webp',
                'website' => 'http://microlab.com/',
            ],
            [
                'name' => 'Microsoft',
                'description' => 'Empowering every person and organization – Microsoft solutions',
                'logo' => 'brands/4UcOhNf93aFEf5onnUo9YjEq4jjURdaUPuJLbGkZ.png',
                'website' => 'http://microsoft.com/',
            ],
            [
                'name' => 'Msi',
                'description' => 'For gamers, by gamers – MSI gaming gear and laptops',
                'logo' => 'brands/d6Km0c4evPygYPd8lLHYj1DXV0rN1ED408mn9VnZ.png',
                'website' => 'https://www.msi.com/',
            ],
            [
                'name' => 'Panasonic',
                'description' => 'A better life, a better world – Panasonic electronics',
                'logo' => 'brands/nduSGyep5oeaE5g2ME4xSTf8hdzaXKe7ztk6FoM0.png',
                'website' => 'https://panasonic.com/',
            ],
            [
                'name' => 'Partner',
                'description' => 'Dependable IT solutions for your business – Partner',
                'logo' => 'brands/6l5nlX0QZ74YPpZcAz8gviKtsTboavwqAg92z9LS.png',
                'website' => 'https://www.partner-tech.com.au',
            ],
            [
                'name' => 'Prolink',
                'description' => 'Connecting the future – Prolink networking',
                'logo' => 'brands/CXw4wBkUCRPCvYXZKTLobvoCYRGdVwys9W1H11Ro.png',
                'website' => 'https://prolink2u.com/',
            ],
            [
                'name' => 'Samsung',
                'description' => 'Imagine the possibilities – Samsung tech for everyone',
                'logo' => 'brands/fp9DnYU7DBf8MVVxYQCziFYq7kZFAz2MRIxxYRT5.webp',
                'website' => null,
            ],
            [
                'name' => 'Sandisk',
                'description' => 'Store more, worry less – SanDisk storage solutions',
                'logo' => 'brands/N1txvaBueBSVwmXLI9zW1zmZ8muGv0LsxCqdsoJe.webp',
                'website' => 'https://www.sandisk.com/',
            ],
            [
                'name' => 'Seagate',
                'description' => 'Trusted storage, endless possibilities – Seagate',
                'logo' => 'brands/bIFQB5r8dGPMVZTy9XcVXKtb3Ur7AkoMf6yUB0mj.jpg',
                'website' => 'https://www.seagate.com/',
            ],
            [
                'name' => 'Sonicgear',
                'description' => 'Premium sound, premium experience – Sonicgear',
                'logo' => 'brands/A8PPtxATEyA29jbRUvxx7JHbpANhS3EyJInYLupn.png',
                'website' => 'https://www.sonicgear.com.my/',
            ],
            [
                'name' => 'Sony',
                'description' => 'Be moved – Sony electronics that inspire',
                'logo' => 'brands/1RXyTRsVO7akIkSXgtZ0QZlxXcSVSeiPHme7xNpI.png',
                'website' => 'https://www.sony.com/',
            ],
            [
                'name' => 'Synology',
                'description' => 'Your data, your control – Synology NAS solutions',
                'logo' => 'brands/8GE8BQaa1Ndpy2JVxHGWOGyXTASZiPzVyLDv8zVA.jpg',
                'website' => 'https://www.synology.com/en-global',
            ],
            [
                'name' => 'Targus',
                'description' => 'Protect, carry, connect – Targus accessories',
                'logo' => 'brands/5bASU0StZzgfLEdE1eYbV2ap735hVd8vZmZBkCPm.jpg',
                'website' => 'https://us.targus.com/',
            ],
            [
                'name' => 'Toshiba',
                'description' => 'Leading innovation, trusted performance – Toshiba',
                'logo' => 'brands/1WlpHbNv57CtUhKy3SfECUXS8NBmkhkmgo9EOYEc.png',
                'website' => 'https://www.toshiba.com',
            ],
            [
                'name' => 'Tp-Link',
                'description' => 'Smarter networking made simple – TP-Link',
                'logo' => 'brands/4PSVIPsyIGGYdjkil8JhIyl9VhTFpwV1q17swCrX.png',
                'website' => 'https://www.tp-link.com',
            ],
            [
                'name' => 'Transcend',
                'description' => 'Reliable storage and memory – Transcend products',
                'logo' => 'brands/jFU8qBuuUYDNAIkRMrhkdLS84JonqFhsSTtldQDZ.png',
                'website' => 'https://www.transcend-info.com/',
            ],
            [
                'name' => 'Us Robotics',
                'description' => 'Connect with confidence – US Robotics networking',
                'logo' => 'brands/1nSO0GZ54qfhSATJun1SexGd65ysov5KhgwkDwSo.png',
                'website' => 'https://www.usrobotics.com/',
            ],
            [
                'name' => 'Vcom',
                'description' => 'Technology that connects – Vcom solutions',
                'logo' => 'brands/rAeCE8bOyXUyJTLxIZVA4e1F4o8l8kNe8uIW0yYL.png',
                'website' => 'https://www.vcom.com.hk/',
            ],
            [
                'name' => 'Viewsonic',
                'description' => 'See the difference – ViewSonic displays and projectors',
                'logo' => 'brands/9NLlESRwuzW5WNRTDF9E953C4i6axw2V9A9jiysf.png',
                'website' => 'https://www.viewsonic.com/',
            ],
            [
                'name' => 'Western Digital',
                'description' => 'Your data, our priority – Western Digital storage',
                'logo' => 'brands/ABe5LrzVxfo7oaehYQOWCFROngIWanatoqUtU97L.png',
                'website' => 'https://www.westerndigital.com/',
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::updateOrCreate(
                ['slug' => Str::slug($brandData['name'])],
                [
                    'name' => $brandData['name'],
                    'description' => $brandData['description'],
                    'logo' => $brandData['logo'],
                    'website' => $brandData['website'],
                    'is_active' => true,
                ]
            );
        }
    }
}
