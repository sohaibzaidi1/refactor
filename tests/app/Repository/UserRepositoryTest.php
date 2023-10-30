<?php
use PHPUnit\Framework\TestCase;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class UserRepositoryTest extends TestCase
{
    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
    }

    public function testCreateOrUpdateWithValidData()
    {
        $requestData = [
            'role' => 'customer',
            'name' => 'Akram',
            'company_id' => 1,
        ];

        $userId = null; // Indicates a new user creation
        $request = new Request($requestData);
        $result = $this->userRepository->createOrUpdate($userId, $request);

        $this->assertInstanceOf(User::class, $result); // Check if a user model is returned
    }

    public function testCreateOrUpdateWithUpdate()
    {
        $user = factory(User::class)->create(); // Create a user for updating
        $requestData = [
            'role' => 'translator',
            'name' => 'Akram',
        ];

        $userId = $user->id; // Indicates an existing user update
        $request = new Request($requestData);
        $result = $this->userRepository->createOrUpdate($userId, $request);

        $this->assertEquals($user->id, $result->id); // Check if the user ID remains the same
    }
}
